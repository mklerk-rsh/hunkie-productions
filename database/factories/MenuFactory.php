<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Main Navigation', 'Footer Menu', 'Social Links',
        ]);

        return [
            'name' => $name,
            'handle' => Str::slug($name, '_'),
            'description' => fake()->sentence(),
        ];
    }
}
