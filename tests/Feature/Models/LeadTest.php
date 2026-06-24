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
}
