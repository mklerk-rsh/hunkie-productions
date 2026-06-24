<?php

namespace Tests\Feature\Models;

use App\Models\BlogPost;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_leads()
    {
        $user = User::factory()->create();
        Lead::factory()->count(3)->create(['assigned_to' => $user->id]);

        $this->assertCount(3, $user->leads);
        $this->assertInstanceOf(Lead::class, $user->leads->first());
    }

    public function test_user_has_many_blog_posts()
    {
        $user = User::factory()->create();
        BlogPost::factory()->count(2)->create(['author_id' => $user->id]);

        $this->assertCount(2, $user->blogPosts);
        $this->assertInstanceOf(BlogPost::class, $user->blogPosts->first());
    }

    public function test_user_can_have_roles()
    {
        $role = Role::create(['name' => 'Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->hasRole('Admin'));
    }

    public function test_active_scope()
    {
        User::factory()->create(['is_active' => true]);
        User::factory()->create(['is_active' => false]);

        $this->assertEquals(1, User::active()->count());
    }
}
