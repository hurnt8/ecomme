<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'settings';

    private const CACHE_TTL = 3600;

    public function current(): Setting
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, fn () => Setting::current());
    }

    public function update(array $data): Setting
    {
        $settings = Setting::current();
        $settings->update($data);

        $this->forget();

        return $settings->fresh();
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
