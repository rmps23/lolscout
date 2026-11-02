<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Services\TeamRoster;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamSearchController extends Controller
{
    public function __invoke(Request $request, TeamRoster $roster): View
    {
        $user = $request->user();
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:40'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'eligible' => ['nullable', 'boolean'],
        ]);
        $myRank = $roster->rankPosition($user);

        $teams = Team::query()
            ->with(['nation', 'minRank'])
            ->withCount('members')
            ->where('looking_for_players', true)
            ->whereDoesntHave('members', fn ($q) => $q->where('user_id', $user->id))
            ->when($filters['q'] ?? null, function ($q, $term) {
                $like = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $term);
                $q->whereLike('name', "%{$like}%");
            })
            ->when($filters['role_id'] ?? null, fn ($q, $roleId) => $q->whereDoesntHave('members', fn ($m) => $m->where('role_id', $roleId)))
            ->when($request->boolean('eligible'), fn ($q) => $q->where(function ($q) use ($myRank) {
                $q->whereNull('min_rank_id')->orWhereHas('minRank', fn ($r) => $r->where('position', '<=', $myRank));
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('teams.search', [
            'teams' => $teams,
            'roles' => Role::orderBy('id')->get(),
            'filters' => $filters,
            'eligible' => $request->boolean('eligible'),
        ]);
    }
}
