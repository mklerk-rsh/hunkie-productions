<?php

namespace Tests\Feature\Models;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_featured_scope()
    {
        Service::factory()->featured()->create(['is_featured' => true]);
        Service::factory()->create(['is_featured' => false]);

        $this->assertEquals(1, Service::featured()->count());
    }

    public function test_ordered_scope()
    {
        Service::factory()->create(['display_order' => 2, 'is_featured' => false]);
        Service::factory()->create(['display_order' => 0, 'is_featured' => false]);
        Service::factory()->create(['display_order' => 1, 'is_featured' => false]);

        $ordered = Service::ordered()->get();
        $this->assertEquals(0, $ordered->first()->display_order);
    }

    public function test_service_has_seo()
    {
        $service = Service::factory()->create();
        $service->seoMetadata()->create([
            'meta_title' => 'Service SEO',
        ]);

        $this->assertNotNull($service->seoMetadata);
    }
}
