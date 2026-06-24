<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['testimonial:view', 'testimonial:create', 'testimonial:update', 'testimonial:delete']);
    }

    public function view(User $user, Testimonial $testimonial): bool
    {
        return $user->hasPermissionTo('testimonial:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('testimonial:create');
    }

    public function update(User $user, Testimonial $testimonial): bool
    {
        return $user->hasPermissionTo('testimonial:update');
    }

    public function delete(User $user, Testimonial $testimonial): bool
    {
        return $user->hasPermissionTo('testimonial:delete');
    }
}
