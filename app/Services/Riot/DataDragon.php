<?php

namespace App\Services\Riot;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/** Static game data (current patch, icons, champion names), cached for hours. */
class DataDragon
{
    private const BASE = 'https://ddragon.leagueoflegends.com';

    public function version(): string
    {
        return Cache::remember('ddragon.version', now()->addHours(6), function () {
            $versions = Http::timeout(8)->get(self::BASE.'/api/versions.json')->throw()->json();

            return $versions[0];
        });
    }

    public function profileIconUrl(?int $iconId): ?string
    {
        if ($iconId === null) {
            return null;
        }

        try {
            return self::BASE.'/cdn/'.$this->version().'/img/profileicon/'.$iconId.'.png';
        } catch (\Throwable) {
            return null;
        }
    }

    /** @return array<int, array{name: string, image: string}> keyed by champion id */
    public function champions(): array
    {
        try {
            return Cache::remember('ddragon.champions', now()->addHours(6), function () {
                $version = $this->version();
                $data = Http::timeout(8)->get(self::BASE."/cdn/{$version}/data/en_US/champion.json")->throw()->json('data');

                $champions = [];
                foreach ($data as $champion) {
                    $champions[(int) $champion['key']] = [
                        'name' => $champion['name'],
                        'image' => self::BASE."/cdn/{$version}/img/champion/".$champion['image']['full'],
                    ];
                }

                return $champions;
            });
        } catch (\Throwable) {
            return [];
        }
    }
}
