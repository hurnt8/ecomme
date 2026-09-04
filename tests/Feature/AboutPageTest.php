<?php

use App\Models\Category;
use App\Models\Product;

it('counts the catalogue instead of stating a figure in the copy', function () {
    $category = Category::factory()->create(['is_active' => true]);
    Product::factory()->count(3)->create(['category_id' => $category->id, 'is_active' => true]);
    Product::factory()->create(['category_id' => $category->id, 'is_active' => false]);

    // Three active, not four: an inactive product is not on sale and must not be advertised.
    $this->get('/a-propos')->assertOk()->assertSee('3 références');
});

it('lists only ranges that actually hold stock, and announces the empty ones', function () {
    $stocked = Category::factory()->create(['name' => 'Mobilier', 'is_active' => true]);
    Product::factory()->create(['category_id' => $stocked->id, 'is_active' => true]);
    Category::factory()->create(['name' => 'Bois & Chauffage', 'is_active' => true]);

    $response = $this->get('/a-propos')->assertOk();

    $ranges = substr($response->getContent(), strpos($response->getContent(), 'about-ranges'), 2500);

    expect($ranges)->toContain('Mobilier')
        ->and($ranges)->not->toContain('about-range" href="'.route('catalog', ['category' => 'bois-chauffage']))
        ->and($ranges)->toContain('arrive prochainement');
});

it('drops the coming-soon note once every range is stocked', function () {
    foreach (['Mobilier', 'Bois & Chauffage'] as $name) {
        $category = Category::factory()->create(['name' => $name, 'is_active' => true]);
        Product::factory()->create(['category_id' => $category->id, 'is_active' => true]);
    }

    // The page has to follow the catalogue without anyone editing the copy.
    $this->get('/a-propos')
        ->assertOk()
        ->assertSee('Bois &amp; Chauffage', false)
        ->assertDontSee('prochainement');
});

it('never claims experience the shop cannot back', function () {
    $this->get('/a-propos')
        ->assertOk()
        ->assertDontSee('+10 ans')
        ->assertDontSee('activité historique');
});
