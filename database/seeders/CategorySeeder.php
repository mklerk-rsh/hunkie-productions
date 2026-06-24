<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Film Production', 'Video Editing', 'Animation',
            'Photography', 'Post Production', 'Sound Design',
            'Visual Effects', 'Motion Graphics', 'Drone Footage',
            'Corporate Video', 'Music Video', 'Documentary',
        ];

        foreach ($categories as $index => $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Projects in {$name} category.",
                'is_active' => true,
                'display_order' => $index,
            ]);
        }
    }
}
