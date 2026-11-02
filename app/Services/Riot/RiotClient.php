<?php

namespace App\Services\Riot;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Thin client for the Riot Games API. Players are identified by PUUID;
 * Riot IDs (gameName#tagLine) come from account-v1.
 */
class RiotClient
{
    public function __construct(
        private readonly ?string $key,
        private readonly string $platform,
        private readonly string $region,
    ) {}

    /** @return array{puuid: string, gameName: string, tagLine: string} */
    public function accountByRiotId(string $gameName, string $tagLine): array
    {
        return $this->get($this->region, '/riot/account/v1/accounts/by-riot-id/'.rawurlencode($gameName).'/'.rawurlencode($tagLine));
    }

    /** @return array{puuid: string, gameName: string, tagLine: string} */
    public function accountByPuuid(string $puuid): array
    {
        return $this->get($this->region, '/riot/account/v1/accounts/by-puuid/'.rawurlencode($puuid));
    }

    /** @return array{profileIconId: int} */
    public function summonerByPuuid(string $puuid): array
    {
        return $this->get($this->platform, '/lol/summoner/v4/summoners/by-puuid/'.rawurlencode($puuid));
    }

    /** The code the player saved in the League client (Settings > Verification), or null. */
    public function thirdPartyCode(string $puuid): ?string
    {
        try {
            $code = $this->get($this->platform, '/lol/platform/v4/third-party-code/by-puuid/'.rawurlencode($puuid));
        } catch (RiotException $e) {
            if ($e->isNotFound()) {
                return null;
            }
            throw $e;
        }

        return is_string($code) && $code !== '' ? $code : null;
    }

    /** @return list<array<string, mixed>> */
    public function leagueEntries(string $puuid): array
    {
        return $this->get($this->platform, '/lol/league/v4/entries/by-puuid/'.rawurlencode($puuid));
    }

    /** @return list<array{championId: int, championLevel: int, championPoints: int}> */
    public function topMasteries(string $puuid, int $count = 3): array
    {
        return $this->get($this->platform, '/lol/champion-mastery/v4/champion-masteries/by-puuid/'.rawurlencode($puuid).'/top', ['count' => $count]);
    }

    private function get(string $host, string $path, array $query = []): mixed
    {
        if (blank($this->key)) {
            throw new RiotException(0, 'RIOT_API_KEY is not configured.');
        }

        try {
            $response = Http::withHeaders(['X-Riot-Token' => $this->key])
                ->acceptJson()
                ->timeout(8)
                ->get("https://{$host}.api.riotgames.com{$path}", $query);
        } catch (ConnectionException) {
            throw new RiotException(0, 'Could not reach the Riot API.');
        }

        if ($response->failed()) {
            throw new RiotException($response->status());
        }

        return $response->json();
    }
}
