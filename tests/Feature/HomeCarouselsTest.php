<?php

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Product;

it('lays the homepage out as carousels: categories, deals, new arrivals and blog', function () {
    // The slug, not the name, is what the deals carousel filters on for the cold season, and the
    // price has to clear HomeController::MIN_DEAL_PRICE — a cheaper discount is held back so the
    // row does not read as a clearance bin.
    $category = Category::factory()->create(['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'is_active' => true]);
    Product::factory()->create([
        'name' => 'Granulés en promotion',
        'category_id' => $category->id,
        'price' => 300,
        'compare_at_price' => 400,
        'stock' => 5,
        'is_active' => true,
    ]);
    BlogPost::factory()->create(['title' => 'Choisir ses granulés', 'published_at' => now()->subDay()]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSeeInOrder([
            'Acheter par catégorie', 'Bois & Chauffage', '1 Produit',
            'Nos offres du jour', '-25%', 'Granulés en promotion',
            'Nouveaux produits', 'Granulés en promotion',
            'Du blog', 'Choisir ses granulés',
        ]);
});

it('leaves the deals carousel out when nothing is on sale', function () {
    Product::factory()->create(['price' => 100, 'compare_at_price' => null, 'stock' => 5, 'is_active' => true]);

    $this->get(route('home'))->assertOk()->assertDontSee('Nos offres du jour');
});
