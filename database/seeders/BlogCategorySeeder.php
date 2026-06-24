<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Industry News', 'Production Tips', 'Behind the Scenes',
            'Case Studies', 'Technology', 'Creative Process',
        ];

        foreach ($categories as $name) {
            BlogCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Blog posts about {$name}.",
                'is_active' => true,
            ]);
        }
    }
}
