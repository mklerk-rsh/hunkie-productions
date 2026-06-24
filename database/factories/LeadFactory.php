<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'message' => fake()->paragraph(3),
            'service_interest' => fake()->randomElement([
                'Film Production', 'Video Editing', 'Animation', 'Photography',
            ]),
            'source' => fake()->randomElement(['website', 'referral', 'google', 'social_media']),
            'status' => fake()->randomElement(['new', 'new', 'new', 'contacted', 'qualified']),
            'lead_score' => fake()->numberBetween(0, 30),
            'assigned_to' => null,
            'notes' => null,
        ];
    }

    public function asNew(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
            'assigned_to' => null,
        ]);
    }

    public function assigned(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'assigned_to' => $userId,
        ]);
    }
}
