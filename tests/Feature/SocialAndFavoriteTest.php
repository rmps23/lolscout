<?php

namespace Tests\Feature;

use App\Models\SocialLink;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Database\Seeders\LookupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SocialAndFavoriteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LookupSeeder::class);
    }

    public static function acceptedLinks(): array
    {
        return [
            ['facebook', 'https://www.facebook.com/lolscout'],
            ['instagram', 'https://instagram.com/lolscout'],
            ['twitter', 'https://x.com/lolscout'],
            ['twitch', 'https://www.twitch.tv/lolscout'],
            ['youtube', 'https://youtu.be/abc123'],
        ];
    }

    public static function rejectedLinks(): array
    {
        return [
            'javascript scheme' => ['twitter', 'javascript:alert(1)'],
            'plain http' => ['twitter', 'http://twitter.com/me'],
            'other site' => ['twitch', 'https://evil.example.com/twitch.tv'],
            'userinfo trick' => ['facebook', 'https://facebook.com@evil.example.com/'],
            'suffix trick' => ['youtube', 'https://notyoutube.com/x'],
            'wrong platform' => ['instagram', 'https://twitter.com/me'],
            'data uri' => ['facebook', 'data:text/html,<script>alert(1)</script>'],
            'spaces' => ['facebook', 'https://facebook.com/a b'],
        ];
    }

    #[DataProvider('acceptedLinks')]
    public function test_valid_platform_links_are_accepted(string $platform, string $url): void
    {
        $this->assertTrue(SocialLink::isValidFor($platform, $url));
    }

    #[DataProvider('rejectedLinks')]
    public function test_unsafe_or_foreign_links_are_rejected(string $platform, string $url): void
    {
        $this->assertFalse(SocialLink::isValidFor($platform, $url));
    }

    public function test_user_can_set_update_and_remove_links(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put('/settings/social', ['twitch' => 'https://twitch.tv/me', 'youtube' => 'https://youtube.com/@me'])
            ->assertSessionHasNoErrors();
        $this->assertSame(2, $user->socialLinks()->count());

        $this->actingAs($user)->put('/settings/social', ['twitch' => 'https://twitch.tv/other', 'youtube' => ''])
            ->assertSessionHasNoErrors();
        $this->assertSame('https://twitch.tv/other', $user->socialLinks()->where('platform', 'twitch')->value('url'));
        $this->assertSame(0, $user->socialLinks()->where('platform', 'youtube')->count());
    }

    public function test_invalid_link_saves_nothing(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put('/settings/social', ['twitch' => 'https://twitch.tv/me', 'twitter' => 'javascript:alert(1)'])
            ->assertSessionHasErrors('twitter');
        $this->assertSame(0, $user->socialLinks()->count());
    }

    public function test_links_render_safely_on_the_profile(): void
    {
        $viewer = User::factory()->create();
        $player = User::factory()->create();
        $player->socialLinks()->create(['platform' => 'twitch', 'url' => 'https://twitch.tv/me']);

        $this->actingAs($viewer)->get(route('players.show', $player))
            ->assertOk()
            ->assertSee('href="https://twitch.tv/me"', false)
            ->assertSee('rel="noopener noreferrer nofollow"', false);
    }

    public function test_only_the_owner_edits_team_links(): void
    {
        $owner = User::factory()->create();
        $team = Team::create(['owner_id' => $owner->id, 'tag' => 'TST', 'name' => 'Test', 'invite_code' => 'x']);
        TeamMember::create(['team_id' => $team->id, 'user_id' => $owner->id, 'role_id' => 1]);

        $this->actingAs(User::factory()->create())->put("/teams/{$team->id}/social", ['twitch' => 'https://twitch.tv/t'])->assertForbidden();
        $this->actingAs($owner)->put("/teams/{$team->id}/social", ['twitch' => 'https://twitch.tv/t'])->assertSessionHasNoErrors();

        $this->assertSame('https://twitch.tv/t', $team->socialLinks()->value('url'));
        $this->assertSame(0, $owner->socialLinks()->count());
    }

    public function test_favourites_add_list_and_remove(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create(['username' => 'Friend']);

        $this->actingAs($me)->post("/favorites/{$other->username}")->assertSessionHasNoErrors();
        $this->actingAs($me)->post("/favorites/{$other->username}");
        $this->assertSame(1, $me->favorites()->count());

        $this->actingAs($me)->get('/favorites')->assertOk()->assertSee('Friend');
        $this->actingAs($me)->get(route('players.show', $other))->assertSee('Remove from favourites');

        $this->actingAs($me)->delete("/favorites/{$other->username}");
        $this->assertSame(0, $me->favorites()->count());
    }

    public function test_cannot_favourite_yourself_and_lists_are_private(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create(['username' => 'Hidden']);
        $someone = User::factory()->create();

        $this->actingAs($me)->post("/favorites/{$me->username}")->assertSessionHasErrors('favorite');
        $this->assertSame(0, $me->favorites()->count());

        $other->favorites()->create(['favorite_user_id' => $someone->id]);
        $this->actingAs($me)->get('/favorites')->assertDontSee($someone->username);
    }
}
