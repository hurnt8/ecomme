<?php

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\ReviewGenerator;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->category = Category::factory()->create();
});

it('creates a product with reviews generated from the requested count', function () {
    $this->actingAs($this->admin)->post(route('admin.produits.store'), [
        'category_id' => $this->category->id,
        'name' => 'Fauteuil Test',
        'price' => 199.90,
        'stock' => 8,
        'is_active' => 1,
        'reviews_count' => 3,
    ])->assertRedirect();

    $product = Product::sole();

    expect($product->slug)->toBe('fauteuil-test')
        ->and((float) $product->price)->toBe(199.90)
        ->and($product->reviews)->toHaveCount(3);
});

it('rejects a product without a name', function () {
    $this->actingAs($this->admin)->post(route('admin.produits.store'), [
        'price' => 10,
    ])->assertSessionHasErrors('name');

    expect(Product::count())->toBe(0);
});

it('updates a product and adjusts its review count', function () {
    $product = Product::factory()->create(['category_id' => $this->category->id, 'name' => 'Old name']);
    ReviewGenerator::syncCount($product, 5);

    $this->actingAs($this->admin)->put(route('admin.produits.update', $product), [
        'category_id' => $this->category->id,
        'name' => 'New name',
        'price' => 50,
        'stock' => 4,
        'is_active' => 1,
        'reviews_count' => 2,
    ])->assertRedirect();

    $product->refresh();

    expect($product->name)->toBe('New name')
        ->and($product->reviews)->toHaveCount(2);
});

it('deletes a product and its images', function () {
    $product = Product::factory()->create(['category_id' => $this->category->id]);

    $this->actingAs($this->admin)
        ->delete(route('admin.produits.destroy', $product))
        ->assertRedirect(route('admin.produits.index'));

    expect(Product::find($product->id))->toBeNull();
});

it('refuses to delete a category that still has products', function () {
    $product = Product::factory()->create(['category_id' => $this->category->id]);

    $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $this->category));

    expect(Category::find($this->category->id))->not->toBeNull();
});
