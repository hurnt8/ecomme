<?php

use App\Models\Product;

it('renders a plain image, not the Owl carousel, for a single-image product', function () {
    $product = Product::factory()->create();
    $product->images()->create(['path' => 'products/test.jpg', 'position' => 0]);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertDontSee('owl-carousel', false)
        ->assertSee('img-responsive', false);
});

it('renders the Owl carousel for a product with multiple images', function () {
    $product = Product::factory()->create();
    $product->images()->create(['path' => 'products/test-1.jpg', 'position' => 0]);
    $product->images()->create(['path' => 'products/test-2.jpg', 'position' => 1]);

    $this->get(route('product.show', $product->slug))
        ->assertOk()
        ->assertSee('owl-carousel', false);
});
