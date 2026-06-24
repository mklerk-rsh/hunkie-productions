<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['service:view', 'service:create', 'service:update', 'service:delete']);
    }

    public function view(User $user, Service $service): bool
    {
        return $user->hasPermissionTo('service:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('service:create');
    }

    public function update(User $user, Service $service): bool
    {
        return $user->hasPermissionTo('service:update');
    }

    public function delete(User $user, Service $service): bool
    {
        return $user->hasPermissionTo('service:delete');
    }
}
