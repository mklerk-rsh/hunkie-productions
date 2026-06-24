<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Film Production', 'Video Editing', 'Animation & Motion Graphics',
            'Photography', 'Post Production', 'Sound Design & Mixing',
            'Visual Effects', 'Drone Services', 'Content Strategy',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(2),
            'content' => fake()->paragraphs(4, true),
            'icon' => fake()->randomElement(['film', 'video-camera', 'magic', 'camera', 'music', 'drone']),
            'is_featured' => fake()->boolean(30),
            'display_order' => fake()->numberBetween(0, 10),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
