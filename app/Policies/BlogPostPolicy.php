<?php

namespace App\Policies;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['blog:view', 'blog:create', 'blog:update', 'blog:delete']);
    }

    public function view(User $user, BlogPost $blogPost): bool
    {
        return $user->hasPermissionTo('blog:view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('blog:create');
    }

    public function update(User $user, BlogPost $blogPost): bool
    {
        return $user->hasPermissionTo('blog:update');
    }

    public function delete(User $user, BlogPost $blogPost): bool
    {
        return $user->hasPermissionTo('blog:delete');
    }

    public function publish(User $user, BlogPost $blogPost): bool
    {
        return $user->hasPermissionTo('blog:publish');
    }
}
