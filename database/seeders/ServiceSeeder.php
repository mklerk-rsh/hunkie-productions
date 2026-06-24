<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Film & Video Production',
                'description' => 'End-to-end video production from concept to final delivery.',
                'icon' => 'film',
                'is_featured' => true,
                'display_order' => 0,
            ],
            [
                'name' => 'Post Production Editing',
                'description' => 'Professional video editing, color grading, and finishing.',
                'icon' => 'scissors',
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Animation & Motion Graphics',
                'description' => 'Custom animation and motion design for any medium.',
                'icon' => 'magic',
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Photography',
                'description' => 'Commercial photography for brands, products, and events.',
                'icon' => 'camera',
                'is_featured' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Sound Design & Mixing',
                'description' => 'Professional audio post-production and sound design.',
                'icon' => 'music',
                'is_featured' => false,
                'display_order' => 4,
            ],
            [
                'name' => 'Drone & Aerial Services',
                'description' => 'High-quality aerial footage and drone cinematography.',
                'icon' => 'drone',
                'is_featured' => false,
                'display_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'content' => 'Full service details including process, deliverables, and case studies. Contact us for a comprehensive consultation tailored to your specific project needs.',
                'icon' => $service['icon'],
                'is_featured' => $service['is_featured'],
                'display_order' => $service['display_order'],
            ]);
        }
    }
}
