<?php

use App\Models\Category;

it('shows the main menu in the header, in order', function () {
    $this->get(route('catalog'))
        ->assertOk()
        ->assertSeeInOrder(['Startseite', 'Über uns', 'Shop', 'Mein Konto', 'Kontakt', 'Sendungsverfolgung']);
});

it('offers the active categories in the header search', function () {
    Category::factory()->create(['name' => 'Bois & Chauffage', 'slug' => 'bois-chauffage', 'is_active' => true]);

    $this->get(route('catalog'))
        ->assertOk()
        ->assertSee('Alle Kategorien')
        ->assertSee('<option value="bois-chauffage"', false);
});
