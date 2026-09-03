<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'settings';

    private const CACHE_TTL = 3600;

    /**
     * Request-scoped copy on top of the Cache::remember() layer below.
     * Without it, every single Blade view/component render re-hits the
     * cache store (a real query against it when CACHE_STORE=database) —
     * the shop layout renders 30+ templates per page (header, footer,
     * every product card, every price/badge component...), each pulling
     * $settings via the global view composer.
     */
    private ?Setting $resolved = null;

    public function current(): Setting
    {
        return $this->resolved ??= Cache::remember(self::CACHE_KEY, self::CACHE_TTL, fn () => Setting::current());
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
        $this->resolved = null;
        Cache::forget(self::CACHE_KEY);
    }
}
