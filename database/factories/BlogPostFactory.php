<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = fake()->unique()->randomElement([
            'The Art of Storytelling in Video Production',
            'Top 10 Tips for Great Corporate Videos',
            'How We Shot Our Latest Documentary',
            'The Future of AI in Video Editing',
            'Why Animation Works for Brand Communication',
            'Behind the Scenes: Our Biggest Project Yet',
            'Sound Design: The Unsung Hero of Film',
            'A Guide to Video Marketing in 2025',
            'Choosing the Right Production Partner',
            'The Power of Authentic Visual Content',
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(8, true),
            'excerpt' => fake()->paragraph(2),
            'blog_category_id' => BlogCategory::factory(),
            'author_id' => User::factory(),
            'is_published' => fake()->boolean(80),
            'is_featured' => fake()->boolean(20),
            'published_at' => now()->subDays(fake()->numberBetween(1, 180)),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
