<?php

use App\Models\Category;
use App\Models\Product;

it('shows a product count next to each category in the sidebar', function () {
    $mobilier = Category::factory()->create(['name' => 'Mobilier', 'slug' => 'mobilier', 'is_active' => true]);
    Product::factory()->count(2)->create(['category_id' => $mobilier->id, 'is_active' => true]);
    Product::factory()->create(['category_id' => $mobilier->id, 'is_active' => false]);

    $response = $this->get(route('catalog'))->assertOk();

    // Only the two active products are counted; the inactive one would 404 from the grid.
    $html = $response->getContent();
    // Wide enough to span the whole category list (the markup is deeply indented, and the
    // "Toutes les pièces" entry comes first).
    $sidebar = substr($html, strpos($html, 'catalog-filter-list'), 3000);

    expect($sidebar)->toContain('Mobilier')
        ->and($sidebar)->toContain('<span class="catalog-filter-qty">2</span>');
});

it('keeps the active category when the sort order changes', function () {
    $mobilier = Category::factory()->create(['slug' => 'mobilier', 'is_active' => true]);
    $deco = Category::factory()->create(['slug' => 'decoration', 'is_active' => true]);

    $kept = Product::factory()->create(['name' => 'Buffet en frêne', 'category_id' => $mobilier->id]);
    $other = Product::factory()->create(['name' => 'Vase en grès', 'category_id' => $deco->id]);

    $this->get(route('catalog', ['category' => 'mobilier', 'sort' => 'price_desc']))
        ->assertOk()
        ->assertSee($kept->name)
        ->assertDontSee($other->name);
});

it('lists each applied filter as a chip that links back without it', function () {
    Category::factory()->create(['name' => 'Mobilier', 'slug' => 'mobilier', 'is_active' => true]);

    $response = $this->get(route('catalog', ['category' => 'mobilier', 'on_sale' => 1]))->assertOk();
    $html = $response->getContent();

    // class="catalog-chip" exactly — 'catalog-chip' alone also matches the chips container.
    expect(substr_count($html, 'class="catalog-chip"'))->toBe(2);

    // Removing one chip keeps the other filter in the link it points at.
    expect($html)->toContain('on_sale=1')
        ->and($html)->toContain('category=mobilier');
});

it('offers a way back to the full catalog when nothing matches', function () {
    Product::factory()->create(['price' => 100]);

    $this->get(route('catalog', ['min_price' => 99999]))
        ->assertOk()
        ->assertSee('Aucune pièce ne correspond')
        ->assertSee('Voir toute la boutique');
});
