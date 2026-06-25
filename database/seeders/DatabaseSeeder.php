<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            AdminUserSeeder::class,
            CategorySeeder::class,
            BlogCategorySeeder::class,
            TagSeeder::class,
            ServiceSeeder::class,
            TeamMemberSeeder::class,
            TestimonialSeeder::class,
            FAQSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
            VisitorTrackingSeeder::class,
        ]);
    }
}
