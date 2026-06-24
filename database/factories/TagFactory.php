<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'video', 'production', 'editing', 'animation', 'photography',
            'film', 'marketing', 'branding', 'drone', 'sound',
            'lighting', 'direction', 'post-production', 'color-grading',
        ]);

        return [
            'name' => ucfirst($name),
            'slug' => $name,
        ];
    }
}
