<?php

namespace Tests\Feature\Services;

use App\Enums\LeadSource;
use App\Models\Lead;
use App\Services\Contracts\GeolocationService;
use App\Services\VisitorTrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class VisitorTrackingServiceTest extends TestCase
{
    use RefreshDatabase;

    private VisitorTrackingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $geoMock = Mockery::mock(GeolocationService::class);
        $geoMock->shouldReceive('locate')
            ->andReturn(null);

        $this->service = new VisitorTrackingService($geoMock);
    }

    public function test_identify_or_create_creates_new_lead()
    {
        $request = Request::create('/api/track/identify', 'POST', [
            'session_id' => 'test-session-123',
            'referrer_url' => 'https://google.com/search?q=hunkie+productions',
            'landing_page' => '/',
        ], server: [
            'REMOTE_ADDR' => '8.8.8.8',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0',
        ]);

        $lead = $this->service->identifyOrCreate($request);

        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'session_id' => 'test-session-123',
            'ip_address' => '8.8.8.8',
            'referrer_url' => 'https://google.com/search?q=hunkie+productions',
            'landing_page' => '/',
            'browser' => 'Chrome',
            'os' => 'Windows',
            'device_type' => 'desktop',
        ]);
        $this->assertNull($lead->email);
        $this->assertTrue($lead->isAnonymous());
    }

    public function test_identify_or_create_returns_existing_lead()
    {
        $existing = Lead::factory()->tracked()->create([
            'session_id' => 'existing-session',
            'name' => null,
            'email' => null,
        ]);

        $request = Request::create('/api/track/identify', 'POST', [
            'session_id' => 'existing-session',
            'referrer_url' => 'https://example.com',
            'landing_page' => '/about',
        ]);

        $lead = $this->service->identifyOrCreate($request);

        $this->assertEquals($existing->id, $lead->id);
    }

    public function test_identify_or_create_from_direct_visit()
    {
        $request = Request::create('/api/track/identify', 'POST', [
            'session_id' => 'direct-visit',
            'landing_page' => '/',
        ], server: [
            'REMOTE_ADDR' => '127.0.0.1',
        ]);

        $lead = $this->service->identifyOrCreate($request);

        $this->assertEquals(LeadSource::Direct->value, $lead->source);
    }

    public function test_record_page_activity()
    {
        $lead = Lead::factory()->create(['page_views_count' => 1]);

        $activity = $this->service->recordPageActivity($lead, [
            'url' => '/portfolio',
            'page_title' => 'Portfolio',
            'action_type' => 'page_view',
        ]);

        $this->assertDatabaseHas('page_activities', [
            'id' => $activity->id,
            'lead_id' => $lead->id,
            'url' => '/portfolio',
        ]);
        $this->assertEquals(2, $lead->fresh()->page_views_count);
    }

    public function test_heartbeat_updates_time_spent()
    {
        $lead = Lead::factory()->tracked()->create([
            'time_spent_seconds' => 0,
        ]);

        $this->service->heartbeat($lead, 30);

        $this->assertEquals(30, $lead->fresh()->time_spent_seconds);
    }

    public function test_heartbeat_accumulates()
    {
        $lead = Lead::factory()->tracked()->create([
            'time_spent_seconds' => 10,
        ]);

        $this->service->heartbeat($lead, 45);

        $this->assertEquals(55, $lead->fresh()->time_spent_seconds);
    }

    public function test_associate_contact_links_visitor_to_lead()
    {
        $lead = Lead::factory()->tracked()->anonymous()->create();

        $this->service->associateContact($lead, [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'company' => 'Acme Inc',
        ]);

        $lead->refresh();

        $this->assertEquals('John Doe', $lead->name);
        $this->assertEquals('john@example.com', $lead->email);
        $this->assertEquals('+1234567890', $lead->phone);
        $this->assertEquals('Acme Inc', $lead->company);
        $this->assertFalse($lead->isAnonymous());
    }
}
