<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("settings.{$key}", 86400, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::setValue($key, $value, $group);
        Cache::forget("settings.{$key}");
    }

    public function getGroup(string $group): array
    {
        return Setting::byGroup($group)->pluck('value', 'key')->toArray();
    }

    public function getAll(): array
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }
}
