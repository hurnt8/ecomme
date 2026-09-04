<?php

use App\Models\Product;

/*
 * A product can exist before its photography does. The fallback used to be
 * template/images/product-1.jpg, so any product still awaiting a photo was illustrated with the
 * concrete rocking chair as though that were the item.
 */

it('falls back to a placeholder, never to another product photo', function () {
    $product = Product::factory()->create();

    expect($product->thumbnail_url)->toStartWith('data:image/svg+xml')
        ->and($product->thumbnail_url)->not->toContain('product-1.jpg')
        ->and($product->hasPhoto())->toBeFalse();
});

it('uses the real photo as soon as there is one', function () {
    $product = Product::factory()->create();
    $product->images()->create(['path' => 'products/real.jpg', 'position' => 0]);

    expect($product->fresh()->thumbnail_url)->toContain('real.jpg')
        ->and($product->fresh()->hasPhoto())->toBeTrue();
});

it('does not show a borrowed photo on the product page of an unphotographed item', function () {
    $product = Product::factory()->create(['name' => 'Bûches de chêne']);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertSee($product->name)
        ->assertDontSee('template/images/product-1.jpg', false)
        // No thumbnail strip for a single placeholder.
        ->assertDontSee('product-gallery-thumb', false);
});

it('shows the placeholder on the catalogue card too', function () {
    Product::factory()->create(['name' => 'Bûches de hêtre', 'is_active' => true, 'stock' => 5]);

    $this->get(route('catalog'))
        ->assertOk()
        ->assertSee('Bûches de hêtre')
        ->assertDontSee('template/images/product-1.jpg', false);
});
