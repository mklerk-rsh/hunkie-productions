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
            'time_spent_seconds' => 0,
            'page_views_count' => 1,
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

    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'email' => null,
            'phone' => null,
            'company' => null,
            'message' => null,
            'notes' => null,
        ]);
    }

    public function tracked(): static
    {
        return $this->state(fn (array $attributes) => [
            'ip_address' => fake()->ipv4(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'user_agent' => fake()->userAgent(),
            'referrer_url' => fake()->url(),
            'landing_page' => '/' . fake()->slug(),
            'time_spent_seconds' => fake()->numberBetween(10, 1800),
            'page_views_count' => fake()->numberBetween(1, 20),
            'device_type' => fake()->randomElement(['desktop', 'mobile', 'tablet']),
            'browser' => fake()->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'os' => fake()->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'session_id' => fake()->uuid(),
        ]);
    }
}
