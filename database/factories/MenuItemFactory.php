<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        return [
            'menu_id' => \App\Models\Menu::factory(),
            'parent_id' => null,
            'title' => fake()->randomElement(['Home', 'About', 'Portfolio', 'Services', 'Blog', 'Contact']),
            'url' => '/' . fake()->randomElement(['', 'about', 'portfolio', 'services', 'blog', 'contact']),
            'route' => null,
            'target' => '_self',
            'icon' => null,
            'is_active' => true,
            'display_order' => fake()->numberBetween(0, 10),
        ];
    }
}
