<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['contact:view', 'contact:delete']);
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('contact:view');
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->hasPermissionTo('contact:delete');
    }

    public function export(User $user): bool
    {
        return $user->hasPermissionTo('contact:export');
    }
}
