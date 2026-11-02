<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

class TeamRoster
{
    /** Why this user cannot apply to the team, or null when they can. */
    public function applyBlocker(Team $team, User $user): ?string
    {
        if ($user->membership()->exists()) {
            return 'You are already in a team.';
        }
        if (! $user->role_id) {
            return 'Choose a role in your settings first.';
        }
        if (! $team->looking_for_players) {
            return 'This team is not recruiting.';
        }
        if ($team->members()->where('role_id', $user->role_id)->exists()) {
            return 'Your role is already taken in this team.';
        }
        if ($team->min_rank_id && $this->rankPosition($user) < $team->minRank->position) {
            return 'Your rank is below the minimum required by this team.';
        }
        if ($user->applications()->where('status', 'pending')->where('team_id', '!=', $team->id)->count() >= Application::MAX_PENDING_PER_USER) {
            return 'You can have at most '.Application::MAX_PENDING_PER_USER.' pending applications.';
        }

        return null;
    }

    /** Position of the player's verified solo-queue rank (0 = unranked or no verified account). */
    public function rankPosition(User $user): int
    {
        $account = $user->riotAccount;

        return $account?->isVerified() ? ($account->rank?->position ?? 0) : 0;
    }

    /**
     * Put a user in a team under a role. Locks the team row so two simultaneous accepts cannot
     * fill the same slot; the unique indexes are the final safety net.
     *
     * @throws TeamRosterException
     */
    public function join(Team $team, User $user, Role $role): TeamMember
    {
        try {
            return DB::transaction(function () use ($team, $user, $role) {
                Team::whereKey($team->id)->lockForUpdate()->firstOrFail();

                if (TeamMember::where('user_id', $user->id)->exists()) {
                    throw new TeamRosterException('That player is already in a team.');
                }
                if (TeamMember::where('team_id', $team->id)->where('role_id', $role->id)->exists()) {
                    throw new TeamRosterException('That role is already taken in this team.');
                }

                $member = TeamMember::create(['team_id' => $team->id, 'user_id' => $user->id, 'role_id' => $role->id]);

                // Joining a team closes every other open application of the player.
                Application::where('user_id', $user->id)->where('status', 'pending')->update(['status' => 'cancelled']);

                return $member;
            });
        } catch (UniqueConstraintViolationException) {
            throw new TeamRosterException('That spot was just taken.');
        }
    }

    /** @return \Illuminate\Support\Collection<int, Rank> */
    public function ranks()
    {
        return Rank::orderBy('position')->get();
    }
}
