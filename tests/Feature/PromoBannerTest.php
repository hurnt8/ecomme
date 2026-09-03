<?php

use App\Models\Banner;
use App\Models\Product;
use App\Models\Setting;

it('filters the catalog to on-sale products only via the Promotions link', function () {
    $onSale = Product::factory()->create(['name' => 'En promo', 'price' => 50, 'compare_at_price' => 80]);
    $fullPrice = Product::factory()->create(['name' => 'Prix normal', 'price' => 50, 'compare_at_price' => null]);

    $this->get(route('catalog', ['on_sale' => 1]))
        ->assertOk()
        ->assertSee($onSale->name)
        ->assertDontSee($fullPrice->name);
});

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

    // Both "Nouveautés" and "Promotions" also appear as plain text earlier in the page (the
    // "Boutique" nav dropdown links to every category plus a Promotions filter), so anchor the
    // search to the promo banner section specifically rather than the first occurrence.
    $html = $response->getContent();
    $bannerSectionStart = strpos($html, 'fh5co-promo-banner');
    $newBannerBlock = substr($html, strpos($html, 'Nouveautés', $bannerSectionStart), 400);
    $saleBannerBlock = substr($html, strpos($html, 'Promotions', $bannerSectionStart), 400);

    expect($newBannerBlock)->not->toContain('fh5co-countdown')
        ->and($saleBannerBlock)->toContain('fh5co-countdown');
});

it('does not show a countdown once sale_ends_at is in the past', function () {
    Setting::current()->update(['sale_ends_at' => now()->subDay()]);
    Banner::create(['title' => 'Promotions', 'image' => 'banners/b.jpg', 'position' => 'shop_sale', 'is_active' => true, 'sort_order' => 0]);

    $this->get(route('catalog'))->assertDontSee('fh5co-countdown', false);
});
