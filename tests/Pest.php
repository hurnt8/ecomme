<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(fn () => Cache::flush())
    ->in('Feature');

// ShippingService/CartService touch the database (settings row, product
// stock lookups), so Unit tests get RefreshDatabase too rather than a
// stricter PHPUnit\Framework\TestCase isolation. Cache::flush() matters
// here specifically: SettingsService caches the settings row indefinitely
// (array store), and RefreshDatabase's transaction rollback would otherwise
// leave a stale cached Setting object bleeding into the next test.
pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(fn () => Cache::flush())
    ->in('Unit');
