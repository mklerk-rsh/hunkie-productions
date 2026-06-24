<?php

namespace Tests\Feature\Services;

use App\Models\Category;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProjectService $projectService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectService = app(ProjectService::class);
    }

    public function test_create_project_with_categories()
    {
        $categories = Category::factory()->count(2)->create();

        $project = $this->projectService->create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'A test project.',
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $this->assertDatabaseHas('projects', ['title' => 'Test Project']);
        $this->assertCount(2, $project->categories);
    }

    public function test_publish_project()
    {
        $project = Project::factory()->draft()->create();

        $this->projectService->publish($project);

        $this->assertEquals('published', $project->fresh()->status);
        $this->assertNotNull($project->fresh()->published_at);
    }

    public function test_get_featured_projects()
    {
        Project::factory()->published()->featured()->create();
        Project::factory()->published()->create();
        Project::factory()->draft()->featured()->create();

        $featured = $this->projectService->getFeaturedProjects();

        $this->assertEquals(1, $featured->count());
    }
}
