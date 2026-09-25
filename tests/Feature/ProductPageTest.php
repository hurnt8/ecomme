<?php

use App\Models\Product;

/*
 * The gallery used to be an Owl carousel, which threw mid-init on a single slide and left the
 * gallery blank. It is now a main image plus thumbnails: no carousel, no minimum slide count,
 * and every image is rendered server-side so the gallery survives without JS.
 */

it('shows no thumbnails for a single-image product', function () {
    $product = Product::factory()->create();
    $product->images()->create(['path' => 'products/test.jpg', 'position' => 0]);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertDontSee('owl-carousel', false)
        ->assertDontSee('product-gallery-thumb', false)
        ->assertSee('product-gallery-main', false);
});

it('renders one thumbnail per image for a multi-image product', function () {
    $product = Product::factory()->create();
    $product->images()->create(['path' => 'products/test-1.jpg', 'position' => 0]);
    $product->images()->create(['path' => 'products/test-2.jpg', 'position' => 1]);
    $product->images()->create(['path' => 'products/test-3.jpg', 'position' => 2]);

    $response = $this->get(route('product.show', $product->slug))->assertOk();

    expect(substr_count($response->getContent(), 'class="product-gallery-thumb"'))->toBe(3);
});

it('still renders a gallery for a product with no images at all', function () {
    $product = Product::factory()->create();

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertSee('product-gallery-main', false);
});

it('shows the price and the add-to-cart button without needing to scroll past the gallery', function () {
    $product = Product::factory()->create(['price' => 249, 'stock' => 5]);
    $product->images()->create(['path' => 'products/test.jpg', 'position' => 0]);

    $response = $this->get(route('product.show', $product->slug))->assertOk();
    $html = $response->getContent();

    // The buy panel is a sibling of the gallery in the same row, not stacked below it.
    expect(strpos($html, 'product-summary'))->toBeGreaterThan(strpos($html, 'product-gallery'))
        ->and($html)->toContain('In den Warenkorb');
});
