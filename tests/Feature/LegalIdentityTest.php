<?php

use App\Models\Order;
use App\Models\Setting;
use App\Services\SettingsService;

/**
 * The registration numbers are legally required on the invoice, the receipt and the mentions
 * légales. All three read them from the settings row, so a single missing binding would silently
 * strip them from a document that must carry them.
 */
beforeEach(function () {
    Setting::query()->updateOrCreate(['id' => 1], [
        'site_name' => 'Souville Bois de Chauffage',
        'legal_name' => 'Frédéric SOUVILLE',
        'legal_form' => 'Entrepreneur individuel',
        'siren' => '981 826 803',
        'siret' => '981 826 803 00018',
        'vat_number' => null,
        'naf_code' => '46.71Z',
        'registered_address' => 'Hourquette, 32300 Estipouy',
        'publication_director' => 'Frédéric SOUVILLE',
        'host_details' => 'Hostinger International Ltd, Larnaca, Chypre',
    ]);

    app(SettingsService::class)->forget();
});

it('prints the registration numbers on the mentions légales', function () {
    $this->get('/mentions-legales')
        ->assertOk()
        ->assertSee('981 826 803 00018')
        ->assertSee('46.71Z')
        ->assertSee('Entrepreneur individuel')
        ->assertSee('Hourquette, 32300 Estipouy')
        ->assertSee('Hostinger International Ltd, Larnaca, Chypre');
});

it('omits the VAT line when the business has no valid number', function () {
    $this->get('/mentions-legales')
        ->assertOk()
        ->assertDontSee('TVA intracommunautaire');
});

it('prints the VAT number once one is filled in', function () {
    Setting::query()->where('id', 1)->update(['vat_number' => 'FR12981826803']);
    app(SettingsService::class)->forget();

    $this->get('/mentions-legales')
        ->assertOk()
        ->assertSee('FR12981826803');
});

it('carries the SIRET in the invoice footer', function () {
    $order = Order::factory()->create();

    $html = view('pdf.invoice', [
        'order' => $order->load('items'),
        'settings' => app(SettingsService::class)->current(),
    ])->render();

    expect($html)
        ->toContain('981 826 803 00018')
        ->toContain('Frédéric SOUVILLE');
});

it('carries the SIRET in the receipt footer', function () {
    // A receipt is only ever rendered for a settled order, and the template prints its paid_at
    // date unguarded — the factory's default order has none.
    $order = Order::factory()->create(['paid_at' => now()]);

    $html = view('pdf.receipt', [
        'order' => $order->load('items'),
        'settings' => app(SettingsService::class)->current(),
    ])->render();

    expect($html)->toContain('981 826 803 00018');
});

/**
 * An empty column must collapse the whole line rather than print a dangling label: a settings row
 * that has not been filled in yet is the normal state of a fresh install.
 */
it('hides the registration block entirely when nothing is filled in', function () {
    Setting::query()->where('id', 1)->update([
        'siren' => null,
        'siret' => null,
        'vat_number' => null,
        'naf_code' => null,
    ]);
    app(SettingsService::class)->forget();

    $this->get('/mentions-legales')
        ->assertOk()
        ->assertDontSee('SIREN :')
        ->assertDontSee('Code NAF/APE :');
});

it('shows the legal identity block in the footer of every page', function () {
    foreach (['/', '/boutique', '/panier'] as $url) {
        $this->get($url)
            ->assertOk()
            ->assertSee('SIREN : 981 826 803')
            ->assertSee('SIRET : 981 826 803 00018')
            ->assertSee('NAF/APE : 46.71Z')
            ->assertSee('Entrepreneur individuel');
    }
});

it('collapses the footer legal block when no identity is filled in', function () {
    Setting::query()->where('id', 1)->update([
        'legal_name' => null,
        'legal_form' => null,
        'siren' => null,
        'siret' => null,
        'naf_code' => null,
        'vat_number' => null,
        'registered_address' => null,
        'contact_address' => null,
    ]);
    app(SettingsService::class)->forget();

    $this->get('/')
        ->assertOk()
        ->assertDontSee('SIREN :')
        ->assertDontSee('fh5co-legal-identity');
});

it('accepts the registration numbers from the admin settings form', function () {
    $admin = App\Models\User::factory()->create(['role' => App\Enums\UserRole::Admin]);

    $this->actingAs($admin)
        ->patch('/admin/reglages', [
            'site_name' => 'Souville Bois de Chauffage',
            'siren' => '981 826 803',
            'siret' => '981 826 803 00018',
            'currency' => 'EUR',
            'tax_rate' => 0.2,
            'free_shipping_threshold' => 500,
            'international_shipping_fee' => 90,
        ])
        ->assertSessionHasNoErrors();

    expect(Setting::query()->first()->siret)->toBe('981 826 803 00018');
});

it('rejects a SIREN that is not nine digits', function () {
    $admin = App\Models\User::factory()->create(['role' => App\Enums\UserRole::Admin]);

    $this->actingAs($admin)
        ->patch('/admin/reglages', [
            'site_name' => 'Souville Bois de Chauffage',
            'siren' => '98182',
            'currency' => 'EUR',
            'tax_rate' => 0.2,
            'free_shipping_threshold' => 500,
            'international_shipping_fee' => 90,
        ])
        ->assertSessionHasErrors('siren');
});
