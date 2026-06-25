<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_belongs_to_many_categories()
    {
        $project = Project::factory()->create();
        $categories = Category::factory()->count(3)->create();
        $project->categories()->attach($categories);

        $this->assertCount(3, $project->categories);
        $this->assertInstanceOf(Category::class, $project->categories->first());
    }

    public function test_published_scope()
    {
        Project::factory()->published()->create();
        Project::factory()->draft()->create();

        $this->assertEquals(1, Project::published()->count());
    }

    public function test_featured_scope()
    {
        Project::factory()->featured()->create();
        Project::factory()->create();

        $this->assertEquals(1, Project::featured()->count());
    }

    public function test_project_has_seo_metadata()
    {
        $project = Project::factory()->published()->create();
        $project->seoMetadata()->create([
            'meta_title' => 'Test Title',
            'meta_description' => 'Test Description',
        ]);

        $this->assertNotNull($project->seoMetadata);
        $this->assertEquals('Test Title', $project->seoMetadata->meta_title);
    }

    public function test_project_casts()
    {
        $project = Project::factory()->create([
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $this->assertIsBool($project->is_featured);
        $this->assertInstanceOf(Carbon::class, $project->published_at);
    }
}
