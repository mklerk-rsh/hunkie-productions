<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@hunkieproductions.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('Super Admin');

        User::firstOrCreate(
            ['email' => 'editor@hunkieproductions.com'],
            [
                'name' => 'Editor User',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        )->assignRole('Editor');

        User::firstOrCreate(
            ['email' => 'leads@hunkieproductions.com'],
            [
                'name' => 'Lead Manager',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        )->assignRole('Lead Manager');
    }
}
