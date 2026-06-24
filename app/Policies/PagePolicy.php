<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['page:view', 'page:create', 'page:update', 'page:delete']);
    }

    public function view(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('page:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('page:create');
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('page:update');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasPermissionTo('page:delete');
    }
}
