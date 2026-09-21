<?php

use App\Models\Category;

it('shows the main menu in the header, in order', function () {
    $this->get(route('catalog'))
        ->assertOk()
        ->assertSeeInOrder(['Accueil', 'À propos', 'Boutique', 'Mon compte', 'Contact', 'Suivi de commande']);
});

it('offers the active categories in the header search', function () {
    Category::factory()->create(['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'is_active' => true]);

    $this->get(route('catalog'))
        ->assertOk()
        ->assertSee('Toutes les catégories')
        ->assertSee('<option value="bois-chauffage"', false);
});
