<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    /** Only the owner edits a team, manages its roster, or deletes it. */
    public function update(User $user, Team $team): bool
    {
        return $team->owner_id === $user->id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $this->update($user, $team);
    }
}
