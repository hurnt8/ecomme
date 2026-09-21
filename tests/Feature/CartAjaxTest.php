<?php

use App\Models\Product;
use App\Services\CartService;

/*
 * Cart forms are sent in the background (resources/js/modules/cart.js). The same routes answer a
 * JSON request with the item count, a toast and the re-rendered cart instead of redirecting back,
 * so adding a product or changing a quantity never reloads the page.
 */

it('adds to the cart without redirecting and returns the new count', function () {
    $product = Product::factory()->create(['name' => 'Tondeuse compacte', 'stock' => 10]);

    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'quantity' => 2])
        ->assertOk()
        ->assertJson(['count' => 2, 'type' => 'success', 'message' => 'Tondeuse compacte ajouté au panier.']);

    expect(app(CartService::class)->count())->toBe(2);
});

it('updates a quantity and sends back the re-rendered lines and totals, without a toast', function () {
    $product = Product::factory()->create(['price' => 120, 'compare_at_price' => null, 'stock' => 10]);
    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    $key = app(CartService::class)->items()->first()->key;

    $response = $this->patchJson(route('cart.update', $key), ['quantity' => 3])
        ->assertOk()
        ->assertJson(['count' => 3, 'message' => null]);

    expect($response->json('html'))->toContain('cart-line-total')->toContain('360');
});

it('removes a line and sends back the empty cart', function () {
    $product = Product::factory()->create(['stock' => 10]);
    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    $key = app(CartService::class)->items()->first()->key;

    $response = $this->deleteJson(route('cart.destroy', $key))
        ->assertOk()
        ->assertJson(['count' => 0, 'message' => 'Article retiré du panier.']);

    expect($response->json('html'))->toContain('Votre panier est vide');
});

it('reports an unavailable product as an error', function () {
    $product = Product::factory()->create(['stock' => 0]);

    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1])
        ->assertStatus(422)
        ->assertJson(['count' => 0, 'type' => 'error']);
});

it('marks the add-to-cart and cart page forms to be sent in the background', function () {
    $product = Product::factory()->create(['stock' => 10]);

    $this->get(route('product.show', $product->slug))->assertOk()->assertSee('data-cart-form', false);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);

    $this->get(route('cart.index'))
        ->assertOk()
        ->assertSee('data-cart-body', false)
        ->assertSee('cartQuantity(1, 10)', false);
});
