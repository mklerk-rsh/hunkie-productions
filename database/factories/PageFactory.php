<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'About Us', 'Our Process', 'Careers', 'Terms of Service',
            'Privacy Policy', 'FAQ', 'Gallery', 'Partners',
        ]);

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'content' => fake()->paragraphs(6, true),
            'layout' => 'default',
            'is_published' => true,
        ];
    }
}
