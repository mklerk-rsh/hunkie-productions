<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['project:view', 'project:create', 'project:update', 'project:delete']);
    }

    public function view(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('project:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('project:create');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('project:update');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('project:delete');
    }

    public function publish(User $user, Project $project): bool
    {
        return $user->hasPermissionTo('project:publish');
    }
}
