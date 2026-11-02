<?php

namespace Tests\Feature;

use App\Models\Rank;
use App\Models\RiotAccount;
use App\Models\User;
use Database\Seeders\LookupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RiotTest extends TestCase
{
    use RefreshDatabase;

    private const PUUID = 'puuid-faker-0001';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LookupSeeder::class);
        config(['services.riot' => ['key' => 'test-key', 'platform' => 'euw1', 'region' => 'europe']]);
        Cache::flush();
    }

    private function fakeRiot(?string $clientCode = null, array $entries = []): void
    {
        Http::fake([
            '*/riot/account/v1/accounts/by-riot-id/*' => Http::response(['puuid' => self::PUUID, 'gameName' => 'Faker', 'tagLine' => 'KR1']),
            '*/riot/account/v1/accounts/by-puuid/*' => Http::response(['puuid' => self::PUUID, 'gameName' => 'Faker', 'tagLine' => 'KR1']),
            '*/lol/summoner/v4/summoners/by-puuid/*' => Http::response(['profileIconId' => 29]),
            '*/lol/platform/v4/third-party-code/by-puuid/*' => $clientCode === null
                ? Http::response(['status' => ['status_code' => 404]], 404)
                : Http::response(json_encode($clientCode), 200, ['Content-Type' => 'application/json']),
            '*/lol/league/v4/entries/by-puuid/*' => Http::response($entries),
            '*/champion-mastery/v4/champion-masteries/by-puuid/*' => Http::response([
                ['championId' => 266, 'championLevel' => 7, 'championPoints' => 123456],
            ]),
            'ddragon.leagueoflegends.com/api/versions.json' => Http::response(['16.1.1']),
            'ddragon.leagueoflegends.com/cdn/*/data/en_US/champion.json' => Http::response([
                'data' => ['Aatrox' => ['key' => '266', 'name' => 'Aatrox', 'image' => ['full' => 'Aatrox.png']]],
            ]),
        ]);
    }

    private function pendingAccount(User $user): RiotAccount
    {
        return RiotAccount::create([
            'user_id' => $user->id, 'puuid' => self::PUUID, 'game_name' => 'Faker', 'tag_line' => 'KR1',
            'verification_code' => 'LOLSCOUT-ABCDEFGHIJ',
        ]);
    }

    public function test_linking_resolves_the_riot_id_and_issues_a_code(): void
    {
        $this->fakeRiot();
        $user = User::factory()->create();

        $this->actingAs($user)->post('/settings/riot', ['riot_id' => 'Faker#KR1'])->assertSessionHasNoErrors();

        $account = $user->fresh()->riotAccount;
        $this->assertSame(self::PUUID, $account->puuid);
        $this->assertStringStartsWith('LOLSCOUT-', $account->verification_code);
        $this->assertNull($account->verified_at);
        Http::assertSent(fn ($request) => $request->hasHeader('X-Riot-Token', 'test-key')
            && str_contains($request->url(), 'europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/Faker/KR1'));
    }

    public function test_riot_id_must_look_like_name_and_tag(): void
    {
        $this->fakeRiot();
        $this->actingAs(User::factory()->create())->post('/settings/riot', ['riot_id' => 'no-tag'])
            ->assertSessionHasErrors('riot_id');
        Http::assertNothingSent();
    }

    public function test_unknown_riot_id_shows_a_friendly_error(): void
    {
        Http::fake(['*' => Http::response([], 404)]);

        $this->actingAs(User::factory()->create())->post('/settings/riot', ['riot_id' => 'Nobody#0000'])
            ->assertSessionHasErrors(['riot_id' => 'Riot could not find that account.']);
    }

    public function test_verification_succeeds_when_the_client_code_matches(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ', [
            ['queueType' => 'RANKED_FLEX_SR', 'tier' => 'SILVER', 'rank' => 'I', 'leaguePoints' => 5],
            ['queueType' => 'RANKED_SOLO_5x5', 'tier' => 'GOLD', 'rank' => 'II', 'leaguePoints' => 63],
        ]);
        $user = User::factory()->create();
        $this->pendingAccount($user);

        $this->actingAs($user)->post('/settings/riot/verify')->assertSessionHasNoErrors();

        $account = $user->fresh()->riotAccount;
        $this->assertTrue($account->isVerified());
        $this->assertNull($account->verification_code);
        $this->assertSame(self::PUUID, $account->verified_puuid);
        $this->assertSame('Gold II', $account->rank->name);
        $this->assertSame(63, $account->league_points);
        $this->assertSame(29, $account->profile_icon_id);
    }

    public function test_verification_fails_when_the_code_is_missing_or_wrong(): void
    {
        $user = User::factory()->create();
        $this->pendingAccount($user);

        $this->fakeRiot(null);
        $this->actingAs($user)->post('/settings/riot/verify')->assertSessionHasErrors('verify');

        $this->fakeRiot('SOMETHING-ELSE');
        $this->actingAs($user)->post('/settings/riot/verify')->assertSessionHasErrors('verify');

        $this->assertFalse($user->fresh()->riotAccount->isVerified());
    }

    public function test_a_verified_account_cannot_be_claimed_by_someone_else(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ');
        $owner = User::factory()->create();
        $this->pendingAccount($owner);
        $this->actingAs($owner)->post('/settings/riot/verify');

        $other = User::factory()->create();
        $this->actingAs($other)->post('/settings/riot', ['riot_id' => 'Faker#KR1'])->assertSessionHasErrors('riot_id');
        $this->assertNull($other->fresh()->riotAccount);
    }

    public function test_verifying_removes_unproven_claims_on_the_same_account(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ');
        $squatter = User::factory()->create();
        RiotAccount::create(['user_id' => $squatter->id, 'puuid' => self::PUUID, 'game_name' => 'Faker', 'tag_line' => 'KR1', 'verification_code' => 'LOLSCOUT-ZZZZZZZZZZ']);
        $owner = User::factory()->create();
        $this->pendingAccount($owner);

        $this->actingAs($owner)->post('/settings/riot/verify')->assertSessionHasNoErrors();

        $this->assertTrue($owner->fresh()->riotAccount->isVerified());
        $this->assertNull($squatter->fresh()->riotAccount);
    }

    public function test_unranked_players_get_the_unranked_rank(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ', []);
        $user = User::factory()->create();
        $this->pendingAccount($user);

        $this->actingAs($user)->post('/settings/riot/verify');

        $this->assertSame(Rank::where('tier', 'UNRANKED')->value('id'), $user->fresh()->riotAccount->rank_id);
    }

    public function test_master_tier_ignores_the_division(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ', [
            ['queueType' => 'RANKED_SOLO_5x5', 'tier' => 'MASTER', 'rank' => 'I', 'leaguePoints' => 210],
        ]);
        $user = User::factory()->create();
        $this->pendingAccount($user);

        $this->actingAs($user)->post('/settings/riot/verify');

        $this->assertSame('Master', $user->fresh()->riotAccount->rank->name);
    }

    public function test_refresh_respects_the_cooldown(): void
    {
        $this->fakeRiot('LOLSCOUT-ABCDEFGHIJ');
        $user = User::factory()->create();
        RiotAccount::create([
            'user_id' => $user->id, 'puuid' => self::PUUID, 'verified_puuid' => self::PUUID, 'game_name' => 'Faker',
            'tag_line' => 'KR1', 'verified_at' => now(), 'synced_at' => now()->subMinute(),
        ]);

        $this->actingAs($user)->post('/settings/riot/refresh')->assertSessionHasErrors('refresh');

        $user->riotAccount->update(['synced_at' => now()->subMinutes(10)]);
        $this->actingAs($user)->post('/settings/riot/refresh')->assertSessionHasNoErrors();
    }

    public function test_riot_outage_does_not_break_the_page(): void
    {
        Http::fake(['*' => Http::response([], 503)]);
        $user = User::factory()->create();

        $this->actingAs($user)->post('/settings/riot', ['riot_id' => 'Faker#KR1'])
            ->assertSessionHasErrors('riot_id');
        $this->actingAs($user)->get('/settings/riot')->assertOk();
    }

    public function test_profile_shows_rank_and_top_champions_for_verified_accounts_only(): void
    {
        $this->fakeRiot();
        $viewer = User::factory()->create();
        $player = User::factory()->create(['bio' => '<b>hello</b>']);
        RiotAccount::create([
            'user_id' => $player->id, 'puuid' => self::PUUID, 'verified_puuid' => self::PUUID, 'game_name' => 'Faker',
            'tag_line' => 'KR1', 'verified_at' => now(), 'rank_id' => Rank::where('name', 'Gold II')->value('id'),
            'league_points' => 63, 'profile_icon_id' => 29,
        ]);

        $this->actingAs($viewer)->get(route('players.show', $player))
            ->assertOk()
            ->assertSee('Faker#KR1')
            ->assertSee('Gold II')
            ->assertSee('Aatrox')
            ->assertSee('123,456')
            ->assertDontSee('<b>hello</b>', false);

        $unlinked = User::factory()->create();
        $this->actingAs($viewer)->get(route('players.show', $unlinked))->assertOk()->assertSee('No verified Riot account');
    }

    public function test_the_api_key_never_reaches_the_browser(): void
    {
        $this->fakeRiot();
        $user = User::factory()->create();
        $this->pendingAccount($user);

        $this->actingAs($user)->get('/settings/riot')->assertOk()->assertDontSee('test-key');
    }
}
