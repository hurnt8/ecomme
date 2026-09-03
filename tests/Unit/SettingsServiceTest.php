<?php

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Cache;

it('resolves the settings row only once per instance, regardless of how many callers ask', function () {
    // The shop layout calls current() from a '*' view composer, so it's hit
    // once per Blade template rendered on a page (header, footer, every
    // product card...). Without request-level memoization on top of
    // Cache::remember(), that meant one real cache-store round trip per
    // template — 30+ per catalog page against the database cache driver.
    Cache::shouldReceive('remember')
        ->once()
        ->andReturn(Setting::current());

    $service = app(SettingsService::class);

    for ($i = 0; $i < 10; $i++) {
        $service->current();
    }
});

it('re-resolves fresh settings after an update', function () {
    $service = app(SettingsService::class);
    expect($service->current()->site_name)->not->toBe('Nouveau Nom');

    $service->update(['site_name' => 'Nouveau Nom']);

    expect($service->current()->site_name)->toBe('Nouveau Nom');
});
