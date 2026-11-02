<?php

namespace Database\Seeders;

use App\Models\Nation;
use App\Models\Rank;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LookupSeeder extends Seeder
{
    /** Rows this seeder creates; used to skip the work on hosts that run it on every start. */
    private const ROLES = 8;

    private const NATIONS = 47;

    private const RANKS = 32;

    public function run(): void
    {
        if (Role::count() >= self::ROLES && Nation::count() >= self::NATIONS && Rank::count() >= self::RANKS) {
            return;
        }

        $roles = [
            ['top', 'Top', 'top.png', true],
            ['jungle', 'Jungle', 'jungler.png', true],
            ['mid', 'Mid', 'mid.png', true],
            ['bot', 'Bot', 'bot.png', true],
            ['support', 'Support', 'support.png', true],
            ['coach', 'Coach', 'coach.png', false],
            ['analyst', 'Analyst', 'other.png', false],
            ['manager', 'Manager', 'manager.png', false],
        ];
        foreach ($roles as [$slug, $name, $image, $isPlayer]) {
            Role::updateOrCreate(['slug' => $slug], compact('name', 'image') + ['is_player' => $isPlayer]);
        }

        $nations = [
            'albania', 'andorra', 'austria', 'belarus', 'belgium', 'bosnia', 'bulgaria', 'croatia', 'cyprus',
            'czechia', 'denmark', 'estonia', 'faroe-islands', 'finland', 'france', 'germany', 'gibraltar',
            'greece', 'hungary', 'iceland', 'ireland', 'italy', 'kosovo', 'latvia', 'liechtenstein', 'lithuania',
            'luxembourg', 'malta', 'moldova', 'monaco', 'montenegro', 'netherlands', 'norway', 'poland',
            'portugal', 'romania', 'russia', 'san-marino', 'serbia', 'slovakia', 'slovenia', 'spain', 'sweden',
            'switzerland', 'turkey', 'uk', 'ukraine',
        ];
        $names = ['uk' => 'United Kingdom', 'bosnia' => 'Bosnia and Herzegovina', 'czechia' => 'Czechia'];
        foreach ($nations as $slug) {
            Nation::updateOrCreate(['slug' => $slug], [
                'name' => $names[$slug] ?? Str::headline($slug),
                'image' => $slug.'.png',
            ]);
        }

        // Position orders ranks from lowest to highest; used for "minimum rank" comparisons.
        $position = 0;
        Rank::updateOrCreate(['tier' => 'UNRANKED', 'division' => null], [
            'name' => 'Unranked', 'position' => $position++, 'image' => 'DEFAULT.png',
        ]);
        foreach (['IRON', 'BRONZE', 'SILVER', 'GOLD', 'PLATINUM', 'EMERALD', 'DIAMOND'] as $tier) {
            foreach (['IV', 'III', 'II', 'I'] as $division) {
                Rank::updateOrCreate(['tier' => $tier, 'division' => $division], [
                    'name' => Str::title($tier).' '.$division,
                    'position' => $position++,
                    'image' => ($tier === 'EMERALD' ? 'PLATINUM' : $tier).'.png',
                ]);
            }
        }
        foreach (['MASTER', 'GRANDMASTER', 'CHALLENGER'] as $tier) {
            Rank::updateOrCreate(['tier' => $tier, 'division' => null], [
                'name' => Str::title($tier), 'position' => $position++, 'image' => $tier.'.png',
            ]);
        }
    }
}
