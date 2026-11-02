<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Riot\DataDragon;
use App\Services\Riot\RiotAccountSynchronizer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function show(Request $request, User $user, DataDragon $ddragon, RiotAccountSynchronizer $synchronizer): View
    {
        $user->load(['role', 'nation', 'riotAccount.rank', 'membership.team', 'socialLinks']);
        $account = $user->riotAccount?->isVerified() ? $user->riotAccount : null;

        $champions = [];
        if ($account) {
            $catalogue = $ddragon->champions();
            foreach ($synchronizer->topMasteries($account) as $mastery) {
                $champions[] = $mastery + ['champion' => $catalogue[$mastery['championId']] ?? null];
            }
        }

        return view('players.show', [
            'player' => $user,
            'account' => $account,
            'iconUrl' => $account ? $ddragon->profileIconUrl($account->profile_icon_id) : null,
            'champions' => $champions,
            'isFavorite' => $request->user()->favorites()->where('favorite_user_id', $user->id)->exists(),
        ]);
    }
}
