<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['team:view', 'team:create', 'team:update', 'team:delete']);
    }

    public function view(User $user, TeamMember $teamMember): bool
    {
        return $user->hasPermissionTo('team:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('team:create');
    }

    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->hasPermissionTo('team:update');
    }

    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->hasPermissionTo('team:delete');
    }
}
