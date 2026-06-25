<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\PageActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageActivityFactory extends Factory
{
    protected $model = PageActivity::class;

    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'url' => '/'.fake()->slug(),
            'page_title' => fake()->words(3, true),
            'action_type' => 'page_view',
            'metadata' => null,
        ];
    }

    public function withMetadata(): static
    {
        return $this->state(fn (array $attributes) => [
            'metadata' => [
                'scroll_depth' => fake()->numberBetween(10, 100),
                'time_on_page' => fake()->numberBetween(5, 120),
            ],
        ]);
    }
}
