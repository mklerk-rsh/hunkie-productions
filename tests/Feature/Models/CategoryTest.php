<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_belongs_to_many_projects()
    {
        $category = Category::factory()->create();
        $projects = Project::factory()->count(2)->create();
        $category->projects()->attach($projects);

        $this->assertCount(2, $category->projects);
        $this->assertInstanceOf(Project::class, $category->projects->first());
    }

    public function test_active_scope()
    {
        Category::factory()->create(['is_active' => true]);
        Category::factory()->inactive()->create();

        $this->assertEquals(1, Category::active()->count());
    }

    public function test_ordered_scope()
    {
        Category::factory()->create(['display_order' => 2]);
        Category::factory()->create(['display_order' => 0]);
        Category::factory()->create(['display_order' => 1]);

        $ordered = Category::ordered()->get();
        $this->assertEquals(0, $ordered->first()->display_order);
    }
}
