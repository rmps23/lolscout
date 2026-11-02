<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Team;
use App\Services\TeamRoster;
use App\Services\TeamRosterException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct(private readonly TeamRoster $roster) {}

    /** Applications the user has sent. */
    public function mine(Request $request): View
    {
        return view('applications.mine', [
            'applications' => $request->user()->applications()->with(['team.nation', 'role'])->latest()->get(),
        ]);
    }

    /** Applications received by teams the user owns. */
    public function inbox(Request $request): View
    {
        $applications = Application::query()
            ->where('status', 'pending')
            ->whereHas('team', fn ($q) => $q->where('owner_id', $request->user()->id))
            ->with(['team', 'role', 'user.riotAccount.rank'])
            ->latest()
            ->get();

        return view('applications.inbox', ['applications' => $applications]);
    }

    public function store(Request $request, Team $team): RedirectResponse
    {
        $user = $request->user();

        if ($reason = $this->roster->applyBlocker($team, $user)) {
            return back()->withErrors(['apply' => $reason]);
        }

        Application::updateOrCreate(
            ['team_id' => $team->id, 'user_id' => $user->id],
            ['role_id' => $user->role_id, 'status' => 'pending'],
        );

        return back()->with('status', 'Application sent.');
    }

    public function destroy(Request $request, Application $application): RedirectResponse
    {
        abort_unless($application->user_id === $request->user()->id, 403);

        $application->delete();

        return back()->with('status', 'Application cancelled.');
    }

    public function accept(Request $request, Application $application): RedirectResponse
    {
        $this->authorizeOwner($request, $application);

        try {
            $this->roster->join($application->team, $application->user, $application->role);
        } catch (TeamRosterException $e) {
            $application->update(['status' => 'declined']);

            return back()->withErrors(['application' => $e->getMessage()]);
        }

        $application->update(['status' => 'accepted']);

        return back()->with('status', $application->user->username.' joined your team.');
    }

    public function decline(Request $request, Application $application): RedirectResponse
    {
        $this->authorizeOwner($request, $application);

        $application->update(['status' => 'declined']);

        return back()->with('status', 'Application declined.');
    }

    private function authorizeOwner(Request $request, Application $application): void
    {
        abort_unless($application->team->owner_id === $request->user()->id && $application->status === 'pending', 403);
    }
}
