<?php

namespace Tests\Feature\Models;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_belongs_to_assigned_user()
    {
        $user = User::factory()->create();
        $lead = Lead::factory()->assigned($user->id)->create();

        $this->assertInstanceOf(User::class, $lead->assignedTo);
        $this->assertEquals($user->id, $lead->assignedTo->id);
    }

    public function test_new_scope()
    {
        Lead::factory()->asNew()->create();
        Lead::factory()->create(['status' => 'contacted']);

        $this->assertEquals(1, Lead::new()->count());
    }

    public function test_unassigned_scope()
    {
        $user = User::factory()->create();
        Lead::factory()->asNew()->create();
        Lead::factory()->assigned($user->id)->create(['status' => 'new']);

        $this->assertEquals(1, Lead::unassigned()->count());
    }

    public function test_by_status_scope()
    {
        Lead::factory()->count(2)->create(['status' => 'new']);
        Lead::factory()->create(['status' => 'won']);

        $this->assertEquals(2, Lead::byStatus('new')->count());
    }

    public function test_lead_score_defaults_to_zero()
    {
        $lead = Lead::factory()->create(['lead_score' => 0]);

        $this->assertEquals(0, $lead->lead_score);
        $this->assertIsInt($lead->lead_score);
    }

    public function test_lead_has_page_activities()
    {
        $lead = Lead::factory()->create();
        $activity = $lead->pageActivities()->create([
            'url' => '/test',
            'page_title' => 'Test',
        ]);

        $this->assertTrue($lead->pageActivities()->exists());
        $this->assertEquals('/test', $activity->url);
    }

    public function test_is_anonymous()
    {
        $identified = Lead::factory()->create(['email' => 'test@example.com']);
        $anonymous = Lead::factory()->anonymous()->create();

        $this->assertFalse($identified->isAnonymous());
        $this->assertTrue($anonymous->isAnonymous());
    }

    public function test_anonymous_scope()
    {
        Lead::factory()->anonymous()->create();
        Lead::factory()->create();

        $this->assertEquals(1, Lead::anonymous()->count());
    }

    public function test_with_email_scope()
    {
        Lead::factory()->anonymous()->create();
        Lead::factory()->create();

        $this->assertEquals(1, Lead::withEmail()->count());
    }

    public function test_from_source_scope()
    {
        Lead::factory()->create(['source' => 'google']);
        Lead::factory()->count(2)->create(['source' => 'direct']);

        $this->assertEquals(1, Lead::fromSource('google')->count());
        $this->assertEquals(2, Lead::fromSource('direct')->count());
    }

    public function test_lead_tracking_fields()
    {
        $lead = Lead::factory()->tracked()->create();

        $this->assertNotNull($lead->ip_address);
        $this->assertNotNull($lead->latitude);
        $this->assertNotNull($lead->longitude);
        $this->assertNotNull($lead->user_agent);
        $this->assertNotNull($lead->session_id);
        $this->assertNotNull($lead->device_type);
        $this->assertNotNull($lead->browser);
        $this->assertNotNull($lead->os);
    }

    public function test_time_spent_and_page_views_defaults()
    {
        $lead = Lead::factory()->create(['time_spent_seconds' => 0, 'page_views_count' => 1]);

        $this->assertEquals(0, $lead->time_spent_seconds);
        $this->assertEquals(1, $lead->page_views_count);
    }

    public function test_lead_cast_types()
    {
        $lead = Lead::factory()->tracked()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'lead_score' => 15,
            'time_spent_seconds' => 120,
            'page_views_count' => 5,
        ]);

        $this->assertIsInt($lead->lead_score);
        $this->assertIsInt($lead->time_spent_seconds);
        $this->assertIsInt($lead->page_views_count);
        $this->assertIsFloat($lead->latitude);
        $this->assertIsFloat($lead->longitude);
    }
}
