<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeamMemberFactory extends Factory
{
    protected $model = TeamMember::class;

    public function definition(): array
    {
        $name = fake()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'position' => fake()->randomElement([
                'Creative Director', 'Video Producer', 'Editor',
                'Cinematographer', 'Sound Engineer', 'Animator',
                'Photographer', 'Post-Production Supervisor', 'Production Assistant',
            ]),
            'bio' => fake()->paragraphs(2, true),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'social_links' => [
                'instagram' => 'https://instagram.com/' . fake()->userName(),
                'linkedin' => 'https://linkedin.com/in/' . fake()->userName(),
            ],
            'display_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
