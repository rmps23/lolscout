<?php

namespace App\Http\Controllers;

use App\Models\Nation;
use App\Models\Team;
use App\Models\TeamMember;
use App\Services\TeamRoster;
use App\Services\TeamRosterException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct(private readonly TeamRoster $roster) {}

    /** "My team": go to the team the user belongs to, or to the create form. */
    public function mine(Request $request): RedirectResponse
    {
        $membership = $request->user()->membership;

        return $membership
            ? redirect()->route('teams.show', $membership->team_id)
            : redirect()->route('teams.create');
    }

    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()->membership) {
            return redirect()->route('teams.mine');
        }

        return view('teams.create', ['nations' => Nation::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $request->merge(['tag' => strtoupper(trim((string) $request->input('tag')))]);

        $data = $request->validate([
            'tag' => ['required', 'regex:/^[A-Z0-9]{2,6}$/'],
            'name' => ['required', 'string', 'min:3', 'max:40', 'regex:/^[\pL\pN _-]+$/u'],
            'nation_id' => ['required', 'exists:nations,id'],
            'info' => ['nullable', 'string', 'max:1000'],
        ], ['tag.regex' => 'The tag must be 2 to 6 letters or numbers.', 'name.regex' => 'The name can only contain letters, numbers, spaces, _ and -.']);

        if (! $user->role_id) {
            return back()->withErrors(['name' => 'Choose a role in your settings before creating a team.']);
        }

        try {
            $team = DB::transaction(function () use ($data, $user) {
                $team = Team::create($data + [
                    'owner_id' => $user->id,
                    'invite_code' => Str::random(32),
                ]);
                $this->roster->join($team, $user, $user->role);

                return $team;
            });
        } catch (TeamRosterException $e) {
            return back()->withInput()->withErrors(['name' => $e->getMessage()]);
        }

        return redirect()->route('teams.show', $team)->with('status', 'Team created.');
    }

    public function show(Request $request, Team $team): View
    {
        $team->load(['nation', 'minRank', 'owner', 'members.user.riotAccount.rank', 'members.role']);
        $user = $request->user();

        return view('teams.show', [
            'team' => $team,
            'isOwner' => $team->owner_id === $user->id,
            'isMember' => $team->members->contains('user_id', $user->id),
            'applyBlocker' => $this->roster->applyBlocker($team, $user),
            'application' => $team->applications()->where('user_id', $user->id)->where('status', 'pending')->first(),
            'openRoles' => $team->openRoles(),
        ]);
    }

    public function edit(Team $team): View
    {
        Gate::authorize('update', $team);

        return view('teams.edit', [
            'team' => $team,
            'nations' => Nation::orderBy('name')->get(),
            'ranks' => $this->roster->ranks(),
        ]);
    }

    public function update(Request $request, Team $team): RedirectResponse
    {
        Gate::authorize('update', $team);
        $request->merge(['tag' => strtoupper(trim((string) $request->input('tag')))]);

        $data = $request->validate([
            'tag' => ['required', 'regex:/^[A-Z0-9]{2,6}$/'],
            'name' => ['required', 'string', 'min:3', 'max:40', 'regex:/^[\pL\pN _-]+$/u'],
            'nation_id' => ['required', 'exists:nations,id'],
            'min_rank_id' => ['nullable', 'exists:ranks,id'],
            'info' => ['nullable', 'string', 'max:1000'],
            'looking_for_players' => ['boolean'],
        ]);
        $data['looking_for_players'] = $request->boolean('looking_for_players');

        $team->update($data);

        return redirect()->route('teams.show', $team)->with('status', 'Team updated.');
    }

    public function destroy(Request $request, Team $team): RedirectResponse
    {
        Gate::authorize('delete', $team);

        $request->validate(['confirm_name' => ['required', 'in:'.$team->name]], ['confirm_name.in' => 'Type the exact team name to confirm.']);

        if ($team->logo_path) {
            Storage::disk('public')->delete($team->logo_path);
        }
        $team->delete();

        return redirect()->route('teams.create')->with('status', 'Team deleted.');
    }

    public function logo(Request $request, Team $team): RedirectResponse
    {
        Gate::authorize('update', $team);

        $request->validate([
            'logo' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024', 'dimensions:max_width=2000,max_height=2000'],
        ]);

        $old = $team->logo_path;
        $team->update(['logo_path' => $request->file('logo')->store('team-logos', 'public')]);
        if ($old) {
            Storage::disk('public')->delete($old);
        }

        return back()->with('status', 'Logo updated.');
    }

    public function regenerateInvite(Team $team): RedirectResponse
    {
        Gate::authorize('update', $team);

        $team->update(['invite_code' => Str::random(32)]);

        return back()->with('status', 'New invite link created; the old one no longer works.');
    }

    public function kick(Team $team, TeamMember $member): RedirectResponse
    {
        Gate::authorize('update', $team);
        abort_unless($member->team_id === $team->id, 404);

        if ($member->user_id === $team->owner_id) {
            return back()->withErrors(['member' => 'The owner cannot be removed. Delete the team instead.']);
        }

        $member->delete();

        return back()->with('status', 'Player removed from the team.');
    }

    public function leave(Request $request, Team $team): RedirectResponse
    {
        $member = $team->members()->where('user_id', $request->user()->id)->firstOrFail();

        if ($team->owner_id === $request->user()->id) {
            return back()->withErrors(['member' => 'Owners cannot leave their team. Delete it instead.']);
        }

        $member->delete();

        return redirect()->route('teams.create')->with('status', 'You left the team.');
    }
}
