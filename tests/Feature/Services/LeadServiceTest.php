<?php

namespace Tests\Feature\Services;

use App\Models\Lead;
use App\Models\User;
use App\Services\LeadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadServiceTest extends TestCase
{
    use RefreshDatabase;

    private LeadService $leadService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leadService = app(LeadService::class);
    }

    public function test_capture_creates_lead()
    {
        $lead = $this->leadService->capture([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Interested in video production services.',
        ]);

        $this->assertDatabaseHas('leads', ['email' => 'john@example.com']);
        $this->assertEquals('new', $lead->status);
        $this->assertEquals('website', $lead->source);
    }

    public function test_calculate_score()
    {
        $score = $this->leadService->calculateScore([
            'company' => 'Acme Inc',
            'phone' => '555-0100',
            'message' => 'A'.str_repeat('x', 100),
            'service_interest' => 'Video Production',
        ]);

        $this->assertEquals(35, $score);
    }

    public function test_assign_lead_to_user()
    {
        $lead = Lead::factory()->new()->create();
        $user = User::factory()->create();

        $this->leadService->assign($lead, $user->id);

        $this->assertEquals($user->id, $lead->fresh()->assigned_to);
    }

    public function test_change_status()
    {
        $lead = Lead::factory()->new()->create();

        $this->leadService->changeStatus($lead, \App\Enums\LeadStatus::Contacted);

        $this->assertEquals('contacted', $lead->fresh()->status);
    }
}
