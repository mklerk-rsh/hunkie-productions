<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create(['key' => 'site_name', 'value' => 'Hunkie Productions', 'group' => 'general']);
        Setting::create(['key' => 'site_description', 'value' => 'Professional video production and creative services.', 'group' => 'general']);
        Setting::create(['key' => 'contact_email', 'value' => 'hello@hunkieproductions.com', 'group' => 'contact']);
        Setting::create(['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'group' => 'contact']);
        Setting::create(['key' => 'address', 'value' => '123 Creative Studio Lane, Los Angeles, CA 90001', 'group' => 'contact']);
        Setting::create(['key' => 'social_instagram', 'value' => 'https://instagram.com/hunkieproductions', 'group' => 'social']);
        Setting::create(['key' => 'social_facebook', 'value' => 'https://facebook.com/hunkieproductions', 'group' => 'social']);
        Setting::create(['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/hunkieproductions', 'group' => 'social']);
    }
}
