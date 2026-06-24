<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->randomElement([
            'Summer Campaign 2025', 'Corporate Rebrand Video',
            'Product Launch Film', 'Documentary Series',
            'Music Video Production', 'Event Coverage',
            'Social Media Content Pack', 'Brand Story Film',
            'Animated Explainer', 'Aerial Reel Compilation',
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(3),
            'content' => fake()->paragraphs(5, true),
            'client_name' => fake()->company(),
            'project_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'completion_year' => fake()->year(),
            'url' => fake()->optional(0.3)->url(),
            'is_featured' => fake()->boolean(20),
            'status' => fake()->randomElement(['draft', 'published', 'published', 'published']),
            'published_at' => now()->subDays(fake()->numberBetween(1, 365)),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
