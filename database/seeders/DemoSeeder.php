<?php

namespace Database\Seeders;

use App\Models\Nation;
use App\Models\Rank;
use App\Models\RiotAccount;
use App\Models\Role;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Local demo data: a verified login plus a few players and teams.
 * Run with `php artisan db:seed --class=DemoSeeder`. Refuses to run in production unless APP_SHOWCASE is on.
 *
 * Demo login (local use only): demo@lolscout.test, with the password in DEMO_PASSWORD (.env).
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction() && ! config('app.showcase')) {
            $this->command?->error('DemoSeeder only runs locally or when APP_SHOWCASE is on.');

            return;
        }

        $password = config('app.demo_password');
        if (blank($password)) {
            $this->command?->error('Set DEMO_PASSWORD in .env first.');

            return;
        }

        // Hosts that seed on every start (the free Render tier) should not redo the slow work:
        // skip when the demo user already exists and the configured password is unchanged.
        if (app()->isProduction()) {
            $existing = User::where('email', 'demo@lolscout.test')->first();
            if ($existing && Hash::check($password, $existing->password)) {
                return;
            }
        }

        $this->call(LookupSeeder::class);

        $demo = $this->player('Demo', 'demo@lolscout.test', 'top', 'Gold II', $password);

        $others = [
            ['Aurora', 'jungle', 'Platinum IV'],
            ['Nightfall', 'mid', 'Diamond III'],
            ['Pixel', 'bot', 'Silver I'],
            ['Haven', 'support', 'Gold IV'],
            ['Mentor', 'coach', null],
        ];
        $players = [];
        foreach ($others as [$name, $role, $rank]) {
            $players[$name] = $this->player($name, Str::lower($name).'@lolscout.test', $role, $rank, Str::random(32));
        }

        $this->team($demo, 'DEM', 'Demo Dragons', 'Casual team looking for a jungler and a mid laner.', 'Silver I', true);
        $nightfall = $this->team($players['Nightfall'], 'NGT', 'Night Owls', 'Scrims every Tuesday and Thursday.', 'Gold IV', true);
        TeamMember::firstOrCreate(['user_id' => $players['Haven']->id], ['team_id' => $nightfall->id, 'role_id' => $players['Haven']->role_id]);
        $this->team($players['Mentor'], 'MNT', 'Mentor Squad', 'Not recruiting right now.', null, false);

        $demo->favorites()->firstOrCreate(['favorite_user_id' => $players['Aurora']->id]);
        $demo->socialLinks()->updateOrCreate(['platform' => 'twitch'], ['url' => 'https://twitch.tv/lolscout']);
    }

    private function player(string $username, string $email, string $roleSlug, ?string $rank, string $password): User
    {
        $user = User::updateOrCreate(['email' => $email], [
            'username' => $username,
            'password' => $password,
            'role_id' => Role::where('slug', $roleSlug)->value('id'),
            'nation_id' => Nation::where('slug', 'portugal')->value('id'),
            'bio' => 'Demo player.',
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        if ($rank) {
            RiotAccount::updateOrCreate(['user_id' => $user->id], [
                'puuid' => 'demo-'.$username,
                'verified_puuid' => 'demo-'.$username,
                'game_name' => $username,
                'tag_line' => 'DEMO',
                'verified_at' => now(),
                'rank_id' => Rank::where('name', $rank)->value('id'),
                'league_points' => rand(0, 99),
            ]);
        }

        return $user;
    }

    private function team(User $owner, string $tag, string $name, string $info, ?string $minRank, bool $recruiting): Team
    {
        $team = Team::updateOrCreate(['owner_id' => $owner->id], [
            'tag' => $tag,
            'name' => $name,
            'info' => $info,
            'nation_id' => $owner->nation_id,
            'min_rank_id' => $minRank ? Rank::where('name', $minRank)->value('id') : null,
            'looking_for_players' => $recruiting,
            'invite_code' => Str::random(32),
        ]);
        TeamMember::firstOrCreate(['user_id' => $owner->id], ['team_id' => $team->id, 'role_id' => $owner->role_id]);

        return $team;
    }
}
