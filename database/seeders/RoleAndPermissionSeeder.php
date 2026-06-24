<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::findOrCreate('user:view');
        Permission::findOrCreate('user:create');
        Permission::findOrCreate('user:update');
        Permission::findOrCreate('user:delete');

        Permission::findOrCreate('role:view');
        Permission::findOrCreate('role:create');
        Permission::findOrCreate('role:update');
        Permission::findOrCreate('role:delete');

        Permission::findOrCreate('project:view');
        Permission::findOrCreate('project:create');
        Permission::findOrCreate('project:update');
        Permission::findOrCreate('project:delete');
        Permission::findOrCreate('project:publish');

        Permission::findOrCreate('service:view');
        Permission::findOrCreate('service:create');
        Permission::findOrCreate('service:update');
        Permission::findOrCreate('service:delete');

        Permission::findOrCreate('team:view');
        Permission::findOrCreate('team:create');
        Permission::findOrCreate('team:update');
        Permission::findOrCreate('team:delete');

        Permission::findOrCreate('testimonial:view');
        Permission::findOrCreate('testimonial:create');
        Permission::findOrCreate('testimonial:update');
        Permission::findOrCreate('testimonial:delete');

        Permission::findOrCreate('blog:view');
        Permission::findOrCreate('blog:create');
        Permission::findOrCreate('blog:update');
        Permission::findOrCreate('blog:delete');
        Permission::findOrCreate('blog:publish');

        Permission::findOrCreate('page:view');
        Permission::findOrCreate('page:create');
        Permission::findOrCreate('page:update');
        Permission::findOrCreate('page:delete');

        Permission::findOrCreate('lead:view');
        Permission::findOrCreate('lead:create');
        Permission::findOrCreate('lead:update');
        Permission::findOrCreate('lead:delete');
        Permission::findOrCreate('lead:assign');

        Permission::findOrCreate('contact:view');
        Permission::findOrCreate('contact:delete');
        Permission::findOrCreate('contact:export');

        Permission::findOrCreate('menu:view');
        Permission::findOrCreate('menu:create');
        Permission::findOrCreate('menu:update');
        Permission::findOrCreate('menu:delete');

        Permission::findOrCreate('setting:view');
        Permission::findOrCreate('setting:update');

        Permission::findOrCreate('activitylog:view');

        $superAdmin = Role::findOrCreate('Super Admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findOrCreate('Admin');
        $admin->givePermissionTo([
            'project:view', 'project:create', 'project:update', 'project:delete', 'project:publish',
            'service:view', 'service:create', 'service:update', 'service:delete',
            'team:view', 'team:create', 'team:update', 'team:delete',
            'testimonial:view', 'testimonial:create', 'testimonial:update', 'testimonial:delete',
            'blog:view', 'blog:create', 'blog:update', 'blog:delete', 'blog:publish',
            'page:view', 'page:create', 'page:update', 'page:delete',
            'lead:view', 'lead:update', 'lead:delete', 'lead:assign',
            'contact:view', 'contact:export',
            'menu:view', 'menu:create', 'menu:update', 'menu:delete',
            'setting:view', 'setting:update',
            'activitylog:view',
        ]);

        $editor = Role::findOrCreate('Editor');
        $editor->givePermissionTo([
            'project:view', 'project:create', 'project:update', 'project:publish',
            'service:view', 'service:create', 'service:update',
            'team:view', 'team:create', 'team:update',
            'testimonial:view', 'testimonial:create', 'testimonial:update',
            'blog:view', 'blog:create', 'blog:update', 'blog:publish',
            'page:view', 'page:create', 'page:update',
            'menu:view',
        ]);

        $leadManager = Role::findOrCreate('Lead Manager');
        $leadManager->givePermissionTo([
            'lead:view', 'lead:update', 'lead:assign',
            'contact:view', 'contact:export',
        ]);

        $support = Role::findOrCreate('Support Staff');
        $support->givePermissionTo([
            'lead:view',
            'contact:view',
        ]);
    }
}
