<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Alex Thompson', 'position' => 'Creative Director'],
            ['name' => 'Maria Garcia', 'position' => 'Video Producer'],
            ['name' => 'James Wilson', 'position' => 'Editor & Colorist'],
            ['name' => 'Sarah Chen', 'position' => 'Cinematographer'],
            ['name' => 'David Kim', 'position' => 'Sound Engineer'],
            ['name' => 'Emma Richards', 'position' => 'Animator'],
        ];

        foreach ($members as $index => $member) {
            TeamMember::create([
                'name' => $member['name'],
                'slug' => Str::slug($member['name']),
                'position' => $member['position'],
                'bio' => 'Experienced professional with a passion for creative excellence. Dedicated to delivering outstanding results for every project and client.',
                'email' => Str::slug($member['name'], '.') . '@hunkieproductions.com',
                'phone' => '+1 (555) 000-0000',
                'social_links' => [
                    'instagram' => 'https://instagram.com/' . Str::slug($member['name'], '.'),
                    'linkedin' => 'https://linkedin.com/in/' . Str::slug($member['name'], '.'),
                ],
                'display_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
