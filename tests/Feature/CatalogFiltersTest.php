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

/**
 * The filter form used to wrap the product grid, which nested every card's add-to-cart form
 * inside it. Nested forms are invalid HTML: browsers drop the inner one, so the button silently
 * submitted the filter form — a GET reload — and nothing reached the basket. The server never
 * saw a bad request, which is why this only shows up in a browser.
 */
it('keeps the add-to-cart forms out of the filter form', function () {
    $category = Category::factory()->create(['is_active' => true]);
    Product::factory()->count(2)->create(['category_id' => $category->id, 'is_active' => true, 'stock' => 5]);

    $html = $this->get(route('catalog'))->assertOk()->getContent();

    // Walk the tags in order: a <form> opening while another is still open is the bug.
    preg_match_all('#</?form\b#', $html, $matches, PREG_OFFSET_CAPTURE);

    $depth = 0;
    $maxDepth = 0;
    foreach ($matches[0] as [$tag]) {
        $depth += str_starts_with($tag, '</') ? -1 : 1;
        $maxDepth = max($maxDepth, $depth);
    }

    expect($maxDepth)->toBe(1, 'un formulaire est imbriqué dans un autre');
});

it('posts the add-to-cart button to the cart, not to the filters', function () {
    $category = Category::factory()->create(['is_active' => true]);
    $product = Product::factory()->create(['category_id' => $category->id, 'is_active' => true, 'stock' => 5]);

    $html = $this->get(route('catalog'))->assertOk()->getContent();

    expect($html)->toContain('action="'.route('cart.store').'"')
        ->and($html)->toContain('value="'.$product->id.'"');
});

/*
 * Cold-season ordering. The catalogue opens on firewood rather than on pools while it is cold,
 * but only where that does not contradict what the shopper asked for.
 */

it('puts cold-season ranges first on the default ordering', function () {
    $wood = Category::factory()->create(['slug' => 'bois-chauffage', 'is_active' => true]);
    $pools = Category::factory()->create(['slug' => 'piscines', 'is_active' => true]);

    // Created after the wood, so "newest first" alone would put the pool at the top.
    Product::factory()->create(['category_id' => $wood->id, 'name' => 'Bûches 50 cm', 'is_active' => true]);
    Product::factory()->create(['category_id' => $pools->id, 'name' => 'Piscine ronde', 'is_active' => true]);

    $html = $this->get(route('catalog'))->assertOk()->getContent();

    expect(strpos($html, 'Bûches 50 cm'))->toBeLessThan(strpos($html, 'Piscine ronde'));
});

it('leaves an explicit sort alone', function () {
    $wood = Category::factory()->create(['slug' => 'bois-chauffage', 'is_active' => true]);
    $pools = Category::factory()->create(['slug' => 'piscines', 'is_active' => true]);

    Product::factory()->create(['category_id' => $wood->id, 'name' => 'Bûches chères', 'price' => 900, 'is_active' => true]);
    Product::factory()->create(['category_id' => $pools->id, 'name' => 'Piscine pas chère', 'price' => 10, 'is_active' => true]);

    $html = $this->get(route('catalog', ['sort' => 'price_asc']))->assertOk()->getContent();

    // Cheapest first, whatever the season: a chosen sort must not be quietly overridden.
    expect(strpos($html, 'Piscine pas chère'))->toBeLessThan(strpos($html, 'Bûches chères'));
});
