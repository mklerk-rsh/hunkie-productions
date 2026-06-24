<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['lead:view', 'lead:update', 'lead:delete']);
    }

    public function view(User $user, Lead $lead): bool
    {
        return $user->hasPermissionTo('lead:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('lead:create');
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->hasPermissionTo('lead:update');
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->hasPermissionTo('lead:delete');
    }

    public function assign(User $user, Lead $lead): bool
    {
        return $user->hasPermissionTo('lead:assign');
    }
}
