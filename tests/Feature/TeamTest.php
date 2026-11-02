<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Nation;
use App\Models\Rank;
use App\Models\Role;
use App\Models\RiotAccount;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Database\Seeders\LookupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LookupSeeder::class);
    }

    private function role(string $slug): Role
    {
        return Role::where('slug', $slug)->firstOrFail();
    }

    private function player(string $roleSlug = 'mid', ?string $rankName = null): User
    {
        $user = User::factory()->create(['role_id' => $this->role($roleSlug)->id, 'nation_id' => Nation::first()->id]);
        if ($rankName) {
            RiotAccount::create([
                'user_id' => $user->id, 'puuid' => 'p-'.$user->id, 'verified_puuid' => 'p-'.$user->id,
                'game_name' => 'N'.$user->id, 'tag_line' => 'EUW', 'verified_at' => now(),
                'rank_id' => Rank::where('name', $rankName)->value('id'),
            ]);
        }

        return $user;
    }

    private function teamOwnedBy(User $owner, array $attributes = []): Team
    {
        $team = Team::create($attributes + [
            'owner_id' => $owner->id, 'tag' => 'TST', 'name' => 'Test Team',
            'nation_id' => Nation::first()->id, 'looking_for_players' => true, 'invite_code' => 'code'.$owner->id,
        ]);
        TeamMember::create(['team_id' => $team->id, 'user_id' => $owner->id, 'role_id' => $owner->role_id]);

        return $team;
    }

    public function test_creating_a_team_makes_the_creator_owner_and_member(): void
    {
        $user = $this->player('top');

        $this->actingAs($user)->post('/teams', [
            'tag' => 'abc', 'name' => 'Alpha Wolves', 'nation_id' => Nation::first()->id, 'info' => 'We scrim.',
        ])->assertSessionHasNoErrors();

        $team = Team::firstOrFail();
        $this->assertSame('ABC', $team->tag);
        $this->assertSame($user->id, $team->owner_id);
        $this->assertSame(32, strlen($team->invite_code));
        $this->assertDatabaseHas('team_members', ['team_id' => $team->id, 'user_id' => $user->id, 'role_id' => $this->role('top')->id]);
    }

    public function test_a_user_can_only_be_in_one_team(): void
    {
        $user = $this->player();
        $this->teamOwnedBy($user);

        $this->actingAs($user)->get('/teams/create')->assertRedirect(route('teams.mine'));
        $this->actingAs($user)->post('/teams', ['tag' => 'XYZ', 'name' => 'Second Team', 'nation_id' => Nation::first()->id])
            ->assertSessionHasErrors('name');
        $this->assertSame(1, Team::count());
    }

    public function test_team_fields_are_validated(): void
    {
        $this->actingAs($this->player())->post('/teams', ['tag' => 'toolongtag', 'name' => '<b>x</b>', 'nation_id' => 999])
            ->assertSessionHasErrors(['tag', 'name', 'nation_id']);
    }

    public function test_only_the_owner_can_edit_delete_upload_or_kick(): void
    {
        Storage::fake('public');
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner);
        $member = TeamMember::create(['team_id' => $team->id, 'user_id' => $this->player('jungle')->id, 'role_id' => $this->role('jungle')->id]);
        $intruder = $this->player('mid');

        $this->actingAs($intruder)->get("/teams/{$team->id}/edit")->assertForbidden();
        $this->actingAs($intruder)->put("/teams/{$team->id}", ['tag' => 'HAX', 'name' => 'Hacked', 'nation_id' => 1])->assertForbidden();
        $this->actingAs($intruder)->delete("/teams/{$team->id}", ['confirm_name' => $team->name])->assertForbidden();
        $this->actingAs($intruder)->post("/teams/{$team->id}/logo", ['logo' => UploadedFile::fake()->image('l.png')])->assertForbidden();
        $this->actingAs($intruder)->post("/teams/{$team->id}/invite")->assertForbidden();
        $this->actingAs($intruder)->delete("/teams/{$team->id}/members/{$member->id}")->assertForbidden();

        $this->assertSame('Test Team', $team->fresh()->name);
        $this->assertModelExists($member);
    }

    public function test_owner_updates_the_team_and_recruiting_flag(): void
    {
        $owner = $this->player();
        $team = $this->teamOwnedBy($owner, ['looking_for_players' => false]);
        $rank = Rank::where('name', 'Gold IV')->first();

        $this->actingAs($owner)->put("/teams/{$team->id}", [
            'tag' => 'nw', 'name' => 'New Name', 'nation_id' => Nation::first()->id, 'min_rank_id' => $rank->id,
            'looking_for_players' => '1', 'info' => 'x',
        ])->assertRedirect();

        $team->refresh();
        $this->assertSame('NW', $team->tag);
        $this->assertTrue($team->looking_for_players);
        $this->assertSame($rank->id, $team->min_rank_id);
    }

    public function test_logo_upload_validates_and_replaces_the_old_file(): void
    {
        Storage::fake('public');
        $owner = $this->player();
        $team = $this->teamOwnedBy($owner);

        $this->actingAs($owner)->post("/teams/{$team->id}/logo", ['logo' => UploadedFile::fake()->create('evil.php', 10, 'application/x-php')])
            ->assertSessionHasErrors('logo');
        $this->actingAs($owner)->post("/teams/{$team->id}/logo", ['logo' => UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf')])
            ->assertSessionHasErrors('logo');

        $this->actingAs($owner)->post("/teams/{$team->id}/logo", ['logo' => UploadedFile::fake()->image('a.png', 100, 100)])->assertSessionHasNoErrors();
        $first = $team->fresh()->logo_path;
        Storage::disk('public')->assertExists($first);

        $this->actingAs($owner)->post("/teams/{$team->id}/logo", ['logo' => UploadedFile::fake()->image('b.png', 100, 100)]);
        Storage::disk('public')->assertMissing($first);
        Storage::disk('public')->assertExists($team->fresh()->logo_path);
    }

    public function test_deleting_a_team_requires_the_exact_name(): void
    {
        $owner = $this->player();
        $team = $this->teamOwnedBy($owner);

        $this->actingAs($owner)->delete("/teams/{$team->id}", ['confirm_name' => 'nope'])->assertSessionHasErrors('confirm_name');
        $this->assertModelExists($team);

        $this->actingAs($owner)->delete("/teams/{$team->id}", ['confirm_name' => 'Test Team'])->assertRedirect(route('teams.create'));
        $this->assertModelMissing($team);
        $this->assertSame(0, TeamMember::count());
    }

    public function test_owner_can_kick_members_but_not_themselves_and_members_can_leave(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner);
        $ownerMember = $team->members()->first();
        $guest = $this->player('jungle');
        $guestMember = TeamMember::create(['team_id' => $team->id, 'user_id' => $guest->id, 'role_id' => $guest->role_id]);

        $this->actingAs($owner)->delete("/teams/{$team->id}/members/{$ownerMember->id}")->assertSessionHasErrors('member');
        $this->assertModelExists($ownerMember);

        $this->actingAs($owner)->delete("/teams/{$team->id}/members/{$guestMember->id}")->assertSessionHasNoErrors();
        $this->assertModelMissing($guestMember);

        $other = $this->player('bot');
        $otherMember = TeamMember::create(['team_id' => $team->id, 'user_id' => $other->id, 'role_id' => $other->role_id]);
        $this->actingAs($other)->delete("/teams/{$team->id}/leave")->assertRedirect(route('teams.create'));
        $this->assertModelMissing($otherMember);
    }

    public function test_apply_and_accept_flow(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner);
        $applicant = $this->player('mid');

        $this->actingAs($applicant)->post("/teams/{$team->id}/apply")->assertSessionHasNoErrors();
        $application = Application::firstOrFail();
        $this->assertSame('pending', $application->status);
        $this->assertSame(1, $owner->pendingInboxCount());

        $this->actingAs($applicant)->post("/applications/{$application->id}/accept")->assertForbidden();

        $this->actingAs($owner)->post("/applications/{$application->id}/accept")->assertSessionHasNoErrors();
        $this->assertSame('accepted', $application->fresh()->status);
        $this->assertDatabaseHas('team_members', ['team_id' => $team->id, 'user_id' => $applicant->id, 'role_id' => $this->role('mid')->id]);
    }

    public function test_declined_and_cancelled_applications(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner);
        $applicant = $this->player('mid');
        $stranger = $this->player('bot');

        $this->actingAs($applicant)->post("/teams/{$team->id}/apply");
        $application = Application::firstOrFail();

        $this->actingAs($stranger)->delete("/applications/{$application->id}")->assertForbidden();
        $this->actingAs($stranger)->post("/applications/{$application->id}/decline")->assertForbidden();

        $this->actingAs($owner)->post("/applications/{$application->id}/decline");
        $this->assertSame('declined', $application->fresh()->status);
        $this->assertDatabaseMissing('team_members', ['user_id' => $applicant->id]);
    }

    public function test_apply_rules(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner, ['min_rank_id' => Rank::where('name', 'Gold IV')->value('id')]);

        // rank below the minimum (and unverified accounts count as unranked)
        $this->actingAs($this->player('mid'))->post("/teams/{$team->id}/apply")->assertSessionHasErrors('apply');
        $this->actingAs($this->player('mid', 'Silver I'))->post("/teams/{$team->id}/apply")->assertSessionHasErrors('apply');
        $this->actingAs($this->player('mid', 'Gold IV'))->post("/teams/{$team->id}/apply")->assertSessionHasNoErrors();

        // role already taken
        $this->actingAs($this->player('top', 'Diamond I'))->post("/teams/{$team->id}/apply")->assertSessionHasErrors('apply');

        // not recruiting
        $team->update(['looking_for_players' => false]);
        $this->actingAs($this->player('bot', 'Diamond I'))->post("/teams/{$team->id}/apply")->assertSessionHasErrors('apply');

        // already in a team
        $this->actingAs($owner)->post("/teams/{$team->id}/apply")->assertSessionHasErrors('apply');

        $this->assertSame(1, Application::count());
    }

    public function test_at_most_three_pending_applications(): void
    {
        $player = $this->player('mid');
        $teams = collect(range(1, 4))->map(fn ($i) => $this->teamOwnedBy($this->player('top'), ['name' => "Team $i"]));

        foreach ($teams->take(3) as $team) {
            $this->actingAs($player)->post("/teams/{$team->id}/apply")->assertSessionHasNoErrors();
        }
        $this->actingAs($player)->post("/teams/{$teams[3]->id}/apply")->assertSessionHasErrors('apply');
        $this->assertSame(3, Application::count());
    }

    public function test_accepting_when_the_slot_was_taken_meanwhile_fails_cleanly(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner);
        $a = $this->player('mid');
        $b = $this->player('mid');
        $this->actingAs($a)->post("/teams/{$team->id}/apply");
        $this->actingAs($b)->post("/teams/{$team->id}/apply");
        [$first, $second] = Application::orderBy('id')->get();

        $this->actingAs($owner)->post("/applications/{$first->id}/accept")->assertSessionHasNoErrors();
        $this->actingAs($owner)->post("/applications/{$second->id}/accept")->assertSessionHasErrors('application');

        $this->assertSame(1, TeamMember::where('team_id', $team->id)->where('role_id', $this->role('mid')->id)->count());
        $this->assertSame('declined', $second->fresh()->status);
    }

    public function test_joining_a_team_cancels_the_players_other_pending_applications(): void
    {
        $player = $this->player('mid');
        $teamA = $this->teamOwnedBy($this->player('top'), ['name' => 'Team A']);
        $teamB = $this->teamOwnedBy($this->player('top'), ['name' => 'Team B']);
        $this->actingAs($player)->post("/teams/{$teamA->id}/apply");
        $this->actingAs($player)->post("/teams/{$teamB->id}/apply");

        $this->actingAs($teamA->owner)->post('/applications/'.Application::where('team_id', $teamA->id)->value('id').'/accept');

        $this->assertSame('cancelled', Application::where('team_id', $teamB->id)->first()->status);
    }

    public function test_invite_link_joins_with_the_users_role_and_ignores_rank(): void
    {
        $owner = $this->player('top');
        $team = $this->teamOwnedBy($owner, ['looking_for_players' => false, 'min_rank_id' => Rank::where('name', 'Diamond I')->value('id')]);
        $guest = $this->player('support');

        $this->actingAs($guest)->get("/invite/{$team->invite_code}")->assertOk()->assertSee($team->name);
        $this->actingAs($guest)->post("/invite/{$team->invite_code}")->assertRedirect(route('teams.show', $team));
        $this->assertDatabaseHas('team_members', ['team_id' => $team->id, 'user_id' => $guest->id]);

        $this->actingAs($this->player('support'))->post("/invite/{$team->invite_code}")->assertSessionHasErrors('invite');
        $this->actingAs($guest)->get('/invite/not-a-code')->assertNotFound();
    }

    public function test_regenerating_the_invite_invalidates_the_old_link(): void
    {
        $owner = $this->player();
        $team = $this->teamOwnedBy($owner);
        $old = $team->invite_code;

        $this->actingAs($owner)->post("/teams/{$team->id}/invite");

        $this->assertNotSame($old, $team->fresh()->invite_code);
        $this->actingAs($this->player('bot'))->get("/invite/{$old}")->assertNotFound();
    }

    public function test_search_filters_by_name_open_role_and_eligibility(): void
    {
        $alpha = $this->teamOwnedBy($this->player('top'), ['name' => 'Alpha Wolves']);
        $beta = $this->teamOwnedBy($this->player('mid'), ['name' => 'Beta Bears', 'min_rank_id' => Rank::where('name', 'Diamond I')->value('id')]);
        $this->teamOwnedBy($this->player('top'), ['name' => 'Hidden Team', 'looking_for_players' => false]);
        $viewer = $this->player('bot', 'Gold IV');

        $this->actingAs($viewer)->get('/teams/search')->assertSee('Alpha Wolves')->assertSee('Beta Bears')->assertDontSee('Hidden Team');
        $this->actingAs($viewer)->get('/teams/search?q=wolves')->assertSee('Alpha Wolves')->assertDontSee('Beta Bears');
        $this->actingAs($viewer)->get('/teams/search?q=WOLVES')->assertSee('Alpha Wolves');
        $this->actingAs($viewer)->get('/teams/search?q=%25')->assertDontSee('Alpha Wolves');
        $this->actingAs($viewer)->get('/teams/search?role_id='.$this->role('top')->id)->assertDontSee('Alpha Wolves')->assertSee('Beta Bears');
        $this->actingAs($viewer)->get('/teams/search?eligible=1')->assertSee('Alpha Wolves')->assertDontSee('Beta Bears');
    }

    public function test_team_text_is_escaped(): void
    {
        $owner = $this->player();
        $team = $this->teamOwnedBy($owner, ['info' => '<script>alert(1)</script>']);

        $this->actingAs($owner)->get("/teams/{$team->id}")->assertOk()->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_guests_and_unverified_users_cannot_use_teams(): void
    {
        $this->get('/teams/search')->assertRedirect(route('login'));
        $this->actingAs(User::factory()->unverified()->create())->get('/teams/search')->assertRedirect(route('verification.notice'));
    }
}
