<?php

namespace Tests\Feature\Models;

use App\Models\Lead;
use App\Models\PageActivity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_activity_belongs_to_lead()
    {
        $lead = Lead::factory()->create();
        $activity = PageActivity::factory()
            ->for($lead)
            ->create();

        $this->assertInstanceOf(Lead::class, $activity->lead);
        $this->assertEquals($lead->id, $activity->lead->id);
    }

    public function test_page_activity_has_required_fields()
    {
        $lead = Lead::factory()->create();
        $activity = PageActivity::factory()
            ->for($lead)
            ->create([
                'url' => '/services',
                'page_title' => 'Our Services',
                'action_type' => 'page_view',
            ]);

        $this->assertEquals('/services', $activity->url);
        $this->assertEquals('Our Services', $activity->page_title);
        $this->assertEquals('page_view', $activity->action_type);
        $this->assertNull($activity->metadata);
    }

    public function test_page_activity_metadata_is_array()
    {
        $lead = Lead::factory()->create();
        $metadata = ['scroll_depth' => 75, 'time_on_page' => 30];
        $activity = PageActivity::factory()
            ->for($lead)
            ->create(['metadata' => $metadata]);

        $this->assertIsArray($activity->metadata);
        $this->assertEquals(75, $activity->metadata['scroll_depth']);
    }
}
