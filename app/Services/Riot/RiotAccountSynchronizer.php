<?php

namespace App\Services\Riot;

use App\Models\Rank;
use App\Models\RiotAccount;
use Illuminate\Support\Facades\Cache;

class RiotAccountSynchronizer
{
    public const COOLDOWN_SECONDS = 300;

    public function __construct(private readonly RiotClient $riot) {}

    public function canSync(RiotAccount $account): bool
    {
        return $account->synced_at === null || $account->synced_at->diffInSeconds(now(), true) >= self::COOLDOWN_SECONDS;
    }

    /**
     * Refresh Riot ID, profile icon and solo-queue rank. Returns false when the cooldown has not elapsed.
     *
     * @throws RiotException
     */
    public function sync(RiotAccount $account, bool $force = false): bool
    {
        if (! $force && ! $this->canSync($account)) {
            return false;
        }

        $identity = $this->riot->accountByPuuid($account->puuid);
        $summoner = $this->riot->summonerByPuuid($account->puuid);
        $solo = collect($this->riot->leagueEntries($account->puuid))->firstWhere('queueType', 'RANKED_SOLO_5x5');

        $account->forceFill([
            'game_name' => $identity['gameName'],
            'tag_line' => $identity['tagLine'],
            'profile_icon_id' => $summoner['profileIconId'] ?? null,
            'rank_id' => $this->rankFor($solo)->id,
            'league_points' => $solo['leaguePoints'] ?? null,
            'synced_at' => now(),
        ])->save();

        Cache::forget($this->masteryKey($account));

        return true;
    }

    /**
     * Top champions by mastery, cached for an hour. Empty when Riot is unreachable.
     *
     * @return list<array{championId: int, championLevel: int, championPoints: int}>
     */
    public function topMasteries(RiotAccount $account): array
    {
        try {
            return Cache::remember($this->masteryKey($account), now()->addHour(), fn () => $this->riot->topMasteries($account->puuid));
        } catch (RiotException) {
            return [];
        }
    }

    private function rankFor(?array $entry): Rank
    {
        if ($entry !== null) {
            $tier = $entry['tier'];
            $division = in_array($tier, ['MASTER', 'GRANDMASTER', 'CHALLENGER'], true) ? null : $entry['rank'];

            $rank = Rank::where('tier', $tier)->where('division', $division)->first();
            if ($rank) {
                return $rank;
            }
        }

        return Rank::where('tier', 'UNRANKED')->firstOrFail();
    }

    private function masteryKey(RiotAccount $account): string
    {
        return 'riot.mastery.'.$account->puuid;
    }
}
