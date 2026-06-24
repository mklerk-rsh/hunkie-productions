<?php

namespace Tests\Feature\Models;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_scope()
    {
        Testimonial::factory()->create(['is_approved' => true]);
        Testimonial::factory()->create(['is_approved' => false]);

        $this->assertEquals(1, Testimonial::approved()->count());
    }

    public function test_featured_scope()
    {
        Testimonial::factory()->featured()->create(['is_featured' => true]);
        Testimonial::factory()->create(['is_featured' => false]);

        $this->assertEquals(1, Testimonial::featured()->count());
    }

    public function test_rating_cast()
    {
        $testimonial = Testimonial::factory()->create(['rating' => 5]);

        $this->assertIsInt($testimonial->rating);
    }
}
