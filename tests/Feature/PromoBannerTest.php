<?php

use App\Models\Banner;
use App\Models\Setting;

it('shows the shop_new and shop_sale banners on the catalog page', function () {
    Banner::create(['title' => 'Nouveautés', 'image' => 'banners/a.jpg', 'position' => 'shop_new', 'is_active' => true, 'sort_order' => 0]);
    Banner::create(['title' => 'Promotions', 'image' => 'banners/b.jpg', 'position' => 'shop_sale', 'is_active' => true, 'sort_order' => 0]);
    Banner::create(['title' => 'Hors sujet', 'image' => 'banners/c.jpg', 'position' => 'home_hero', 'is_active' => true, 'sort_order' => 0]);

    $response = $this->get(route('catalog'));

    $response->assertOk()->assertSee('Nouveautés')->assertSee('Promotions')->assertDontSee('Hors sujet');
});

it('hides inactive banners', function () {
    Banner::create(['title' => 'Ancienne promo', 'image' => 'banners/a.jpg', 'position' => 'shop_sale', 'is_active' => false, 'sort_order' => 0]);

    $this->get(route('catalog'))->assertDontSee('Ancienne promo');
});

it('shows a live countdown only on the shop_sale banner, only while sale_ends_at is in the future', function () {
    Setting::current()->update(['sale_ends_at' => now()->addDays(3)]);
    Banner::create(['title' => 'Nouveautés', 'image' => 'banners/a.jpg', 'position' => 'shop_new', 'is_active' => true, 'sort_order' => 0]);
    Banner::create(['title' => 'Promotions', 'image' => 'banners/b.jpg', 'position' => 'shop_sale', 'is_active' => true, 'sort_order' => 0]);

    $response = $this->get(route('catalog'));
    $response->assertOk();

    $html = $response->getContent();
    $newBannerBlock = substr($html, strpos($html, 'Nouveautés'), 400);
    $saleBannerBlock = substr($html, strpos($html, 'Promotions'), 400);

    expect($newBannerBlock)->not->toContain('fh5co-countdown')
        ->and($saleBannerBlock)->toContain('fh5co-countdown');
});

it('does not show a countdown once sale_ends_at is in the past', function () {
    Setting::current()->update(['sale_ends_at' => now()->subDay()]);
    Banner::create(['title' => 'Promotions', 'image' => 'banners/b.jpg', 'position' => 'shop_sale', 'is_active' => true, 'sort_order' => 0]);

    $this->get(route('catalog'))->assertDontSee('fh5co-countdown', false);
});
