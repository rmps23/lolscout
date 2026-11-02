<?php

namespace App\Http\Controllers;

use App\Models\RiotAccount;
use App\Services\Riot\DataDragon;
use App\Services\Riot\RiotAccountSynchronizer;
use App\Services\Riot\RiotClient;
use App\Services\Riot\RiotException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RiotAccountController extends Controller
{
    public function __construct(
        private readonly RiotClient $riot,
        private readonly RiotAccountSynchronizer $synchronizer,
    ) {}

    public function show(Request $request, DataDragon $ddragon): View
    {
        $account = $request->user()->riotAccount;

        return view('settings.riot', [
            'account' => $account,
            'iconUrl' => $account?->isVerified() ? $ddragon->profileIconUrl($account->profile_icon_id) : null,
            'canRefresh' => $account && $account->isVerified() && $this->synchronizer->canSync($account),
        ]);
    }

    /** Step 1: resolve the Riot ID and hand out a code to save in the League client. */
    public function link(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'riot_id' => ['required', 'string', 'regex:/^.{3,16}#[A-Za-z0-9]{3,5}$/u'],
        ], ['riot_id.regex' => 'Enter your Riot ID like Name#TAG.']);

        [$gameName, $tagLine] = explode('#', $data['riot_id'], 2);

        try {
            $identity = $this->riot->accountByRiotId(trim($gameName), $tagLine);
        } catch (RiotException $e) {
            report_if($e->status !== 404, $e);

            return back()->withInput()->withErrors(['riot_id' => $e->userMessage()]);
        }

        $taken = RiotAccount::where('verified_puuid', $identity['puuid'])
            ->where('user_id', '!=', $request->user()->id)->exists();
        if ($taken) {
            return back()->withInput()->withErrors(['riot_id' => 'That Riot account is already linked to another LOLSCOUT user.']);
        }

        RiotAccount::updateOrCreate(['user_id' => $request->user()->id], [
            'puuid' => $identity['puuid'],
            'game_name' => $identity['gameName'],
            'tag_line' => $identity['tagLine'],
            'verification_code' => 'LOLSCOUT-'.Str::upper(Str::random(10)),
            'verified_puuid' => null,
            'verified_at' => null,
            'profile_icon_id' => null,
            'rank_id' => null,
            'league_points' => null,
            'synced_at' => null,
        ]);

        return back()->with('status', 'Now save the code in your League client, then press Verify.');
    }

    /** Step 2: check that the code saved in the client matches the one we issued. */
    public function verify(Request $request): RedirectResponse
    {
        $account = $request->user()->riotAccount;
        if (! $account || $account->isVerified() || ! $account->verification_code) {
            return back();
        }

        try {
            $clientCode = $this->riot->thirdPartyCode($account->puuid);
        } catch (RiotException $e) {
            report_if($e->status !== 404, $e);

            return back()->withErrors(['verify' => $e->userMessage()]);
        }

        if ($clientCode === null || ! hash_equals($account->verification_code, $clientCode)) {
            return back()->withErrors(['verify' => 'We could not find the code in your client. Save it under Settings > Verification, then try again.']);
        }

        $claimed = DB::transaction(function () use ($account) {
            if (RiotAccount::where('verified_puuid', $account->puuid)->exists()) {
                return false;
            }

            $account->forceFill([
                'verified_puuid' => $account->puuid,
                'verified_at' => now(),
                'verification_code' => null,
            ])->save();

            // Anyone else who started linking this account without proof loses the claim.
            RiotAccount::where('puuid', $account->puuid)->where('id', '!=', $account->id)->delete();

            return true;
        });

        if (! $claimed) {
            return back()->withErrors(['verify' => 'That Riot account is already linked to another LOLSCOUT user.']);
        }

        try {
            $this->synchronizer->sync($account, force: true);
        } catch (RiotException $e) {
            report_if($e->status !== 404, $e);

            return back()->with('status', 'Account verified. Your rank will appear after the next refresh.');
        }

        return back()->with('status', 'Riot account verified!');
    }

    public function refresh(Request $request): RedirectResponse
    {
        $account = $request->user()->riotAccount;
        abort_unless($account?->isVerified(), 404);

        try {
            $updated = $this->synchronizer->sync($account);
        } catch (RiotException $e) {
            report_if($e->status !== 404, $e);

            return back()->withErrors(['refresh' => $e->userMessage()]);
        }

        return $updated
            ? back()->with('status', 'Rank and icon updated.')
            : back()->withErrors(['refresh' => 'Your profile was updated recently, try again in a few minutes.']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->riotAccount?->delete();

        return back()->with('status', 'Riot account unlinked.');
    }
}
