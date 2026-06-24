<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'video', 'production', 'editing', 'animation', 'photography',
            'film', 'marketing', 'branding', 'drone', 'sound',
            'lighting', 'direction', 'post-production', 'color-grading',
            'cinematography', 'motion-graphics',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => ucfirst(str_replace('-', ' ', $tag)),
                'slug' => $tag,
            ]);
        }
    }
}
