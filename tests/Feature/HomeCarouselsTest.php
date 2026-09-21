<?php

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Product;

it('lays the homepage out as carousels: categories, deals, new arrivals and blog', function () {
    $category = Category::factory()->create(['name' => 'Bois & Chauffage', 'is_active' => true]);
    Product::factory()->create([
        'name' => 'Granulés en promotion',
        'category_id' => $category->id,
        'price' => 75,
        'compare_at_price' => 100,
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
