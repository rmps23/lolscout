<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Services\TeamRoster;
use App\Services\TeamRosterException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InviteController extends Controller
{
    public function show(string $code): View
    {
        $team = Team::where('invite_code', $code)->with(['nation', 'members.role'])->firstOrFail();

        return view('teams.invite', ['team' => $team]);
    }

    /** An invite link skips the "recruiting" and minimum-rank checks: the owner chose to share it. */
    public function accept(Request $request, string $code, TeamRoster $roster): RedirectResponse
    {
        $team = Team::where('invite_code', $code)->firstOrFail();
        $user = $request->user();

        if (! $user->role) {
            return back()->withErrors(['invite' => 'Choose a role in your settings first.']);
        }

        try {
            $roster->join($team, $user, $user->role);
        } catch (TeamRosterException $e) {
            return back()->withErrors(['invite' => $e->getMessage()]);
        }

        return redirect()->route('teams.show', $team)->with('status', 'Welcome to '.$team->name.'!');
    }
}
