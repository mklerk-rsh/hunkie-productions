<?php

namespace Database\Factories;

use App\Models\FAQ;
use Illuminate\Database\Eloquent\Factories\Factory;

class FAQFactory extends Factory
{
    protected $model = FAQ::class;

    public function definition(): array
    {
        return [
            'question' => fake()->unique()->sentence() . '?',
            'answer' => fake()->paragraphs(2, true),
            'category' => fake()->randomElement(['General', 'Pricing', 'Process', 'Technical']),
            'display_order' => fake()->numberBetween(0, 10),
            'is_published' => true,
        ];
    }
}
