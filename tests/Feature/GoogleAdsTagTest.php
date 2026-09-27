<?php

use App\Models\Product;

/**
 * Google Ads refuse de valider un compte tant qu'il ne voit pas gtag.js sur le site. Le tag a
 * déjà disparu une fois — présent sur une branche, absent de celle qui est déployée — et rien
 * ne l'avait signalé : la boutique s'affichait parfaitement sans lui.
 */
it('serves the gtag.js snippet on the storefront when an Ads id is configured', function () {
    config(['services.google_ads.id' => 'AW-18475917188']);

    $response = $this->get(route('home'))->assertOk();

    // Les deux moitiés comptent : le chargement de la bibliothèque et l'appel config().
    // Le validateur de Google cherche la première, le suivi ne marche que grâce à la seconde.
    $response->assertSee('googletagmanager.com/gtag/js?id=AW-18475917188', false)
        ->assertSee("gtag('config', 'AW-18475917188')", false);
});

it('leaves the tag out when no Ads id is configured', function () {
    config(['services.google_ads.id' => null]);

    // Sans cela, le local et la préproduction enverraient leurs visites dans le compte réel.
    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('googletagmanager.com', false);
});

it('reports the purchase as a conversion on the confirmation page', function () {
    config(['services.google_ads.id' => 'AW-18475917188']);

    $product = Product::factory()->create(['price' => 200, 'stock' => 5]);

    $this->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 1]);
    $this->post(route('checkout.store'), [
        'customer_name' => 'Camille Dupont',
        'customer_email' => 'camille@example.com',
        'address_line1' => '12 rue des Lilas',
        'postal_code' => '75011',
        'city' => 'Paris',
        'country' => 'FR',
    ]);

    // La valeur et la devise sont ce qui permet a Google Ads de chiffrer un retour ; un
    // evenement sans elles compte la vente mais pas ce qu'elle rapporte.
    $this->get(route('checkout.confirmation'))
        ->assertOk()
        ->assertSee('ads_conversion_Formulaire_1', false)
        ->assertSee("'currency': 'EUR'", false);
});
