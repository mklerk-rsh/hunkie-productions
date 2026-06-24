<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;

class MenuPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['menu:view', 'menu:create', 'menu:update', 'menu:delete']);
    }

    public function view(User $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('menu:create');
    }

    public function update(User $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu:update');
    }

    public function delete(User $user, Menu $menu): bool
    {
        return $user->hasPermissionTo('menu:delete');
    }
}
