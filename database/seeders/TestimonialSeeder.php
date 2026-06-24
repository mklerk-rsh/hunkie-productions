<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'John Smith',
                'client_company' => 'TechVentures Inc.',
                'content' => 'Hunkie Productions delivered an incredible corporate video that perfectly captured our brand story. Their attention to detail and creative vision exceeded our expectations.',
                'rating' => 5,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Lisa Park',
                'client_company' => 'BrightStar Media',
                'content' => 'Working with this team was an absolute pleasure. They understood our vision from day one and produced a stunning animation that our clients love.',
                'rating' => 5,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Michael Torres',
                'client_company' => 'GreenLeaf Agency',
                'content' => 'The drone footage they captured for our real estate project was breathtaking. Highly professional and delivered ahead of schedule.',
                'rating' => 5,
                'is_featured' => false,
            ],
            [
                'client_name' => 'Rachel Adams',
                'client_company' => 'Summit Brands',
                'content' => 'We have worked with many production companies, but Hunkie Productions stands out for their creativity, reliability, and exceptional quality.',
                'rating' => 5,
                'is_featured' => false,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::create([
                'client_name' => $testimonial['client_name'],
                'client_company' => $testimonial['client_company'],
                'content' => $testimonial['content'],
                'rating' => $testimonial['rating'],
                'is_featured' => $testimonial['is_featured'],
                'is_approved' => true,
                'display_order' => $index,
            ]);
        }
    }
}
