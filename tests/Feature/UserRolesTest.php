<?php

use App\Enums\UserRole;
use App\Models\User;

function admin(): User
{
    return User::factory()->create(['role' => UserRole::Admin]);
}

function supervisor(): User
{
    return User::factory()->create(['role' => UserRole::Supervisor]);
}

/*
 * Access. Each restricted page is requested by hand rather than checked through the menu: hiding
 * a sidebar entry is presentation, and a supervisor who types the URL must still be refused.
 */

it('lets a supervisor reach the orders screens only', function () {
    $this->actingAs(supervisor());

    $this->get('/admin/commandes')->assertOk();

    foreach (['/admin/produits', '/admin/categories', '/admin/bannieres', '/admin/utilisateurs', '/admin/reglages'] as $url) {
        $this->get($url)->assertForbidden();
    }
});

it('sends a supervisor from the dashboard to the orders list', function () {
    $this->actingAs(supervisor())
        ->get('/admin')
        ->assertRedirect(route('admin.commandes.index'));
});

it('keeps customers out of the back-office entirely', function () {
    $this->actingAs(User::factory()->create(['role' => UserRole::Customer]));

    $this->get('/admin')->assertForbidden();
    $this->get('/admin/commandes')->assertForbidden();
});

it('leaves the admin with every screen', function () {
    $this->actingAs(admin());

    foreach (['/admin', '/admin/commandes', '/admin/produits', '/admin/utilisateurs', '/admin/reglages'] as $url) {
        $this->get($url)->assertOk();
    }
});

it('hides admin-only entries from the supervisor menu', function () {
    $html = $this->actingAs(supervisor())->get('/admin/commandes')->assertOk()->getContent();

    expect($html)->toContain(route('admin.commandes.index'))
        ->and($html)->not->toContain(route('admin.produits.index'))
        ->and($html)->not->toContain(route('admin.utilisateurs.index'));
});

/*
 * The way back from the storefront.
 */

/**
 * Isolates the staff bar. The dashboard URL is a prefix of every other admin URL, so asserting
 * against the whole page cannot tell "links to /admin" from "links to /admin/commandes".
 */
function staffBar(string $html): string
{
    $start = strpos($html, 'admin-return-bar');
    expect($start)->not->toBeFalse('bandeau de retour absent de la page');

    return substr($html, $start, strpos($html, '</div>', $start) - $start + 6);
}

it('shows staff a link back to the back-office from the shop', function () {
    $html = $this->actingAs(admin())->get('/')->assertOk()->getContent();

    expect($html)->toContain('Zurück zur Verwaltung')
        ->and(staffBar($html))->toContain(route('admin.dashboard'));
});

it('points the supervisor at the orders list rather than the dashboard', function () {
    $bar = staffBar($this->actingAs(supervisor())->get('/')->assertOk()->getContent());

    expect($bar)->toContain(route('admin.commandes.index'));
});

it('never shows that bar to a customer', function () {
    $this->actingAs(User::factory()->create(['role' => UserRole::Customer]))
        ->get('/')
        ->assertOk()
        ->assertDontSee('Zurück zur Verwaltung');
});

it('never shows that bar to a visitor', function () {
    $this->get('/')->assertOk()->assertDontSee('Zurück zur Verwaltung');
});

/*
 * Managing team accounts.
 */

it('creates a supervisor from the admin form', function () {
    $this->actingAs(admin())
        ->post('/admin/utilisateurs', [
            'name' => 'Nouvelle recrue',
            'email' => 'recrue@example.test',
            'password' => 'mot-de-passe-solide-42',
            'password_confirmation' => 'mot-de-passe-solide-42',
            'role' => UserRole::Supervisor->value,
        ])
        ->assertRedirect(route('admin.utilisateurs.index'));

    $created = User::query()->where('email', 'recrue@example.test')->first();

    expect($created)->not->toBeNull()
        ->and($created->role)->toBe(UserRole::Supervisor)
        // Created by someone who already knows them: no verification wall on first sign-in.
        ->and($created->email_verified_at)->not->toBeNull();
});

it('refuses to create a user with the customer role', function () {
    $this->actingAs(admin())
        ->post('/admin/utilisateurs', [
            'name' => 'Client déguisé',
            'email' => 'deguise@example.test',
            'password' => 'mot-de-passe-solide-42',
            'password_confirmation' => 'mot-de-passe-solide-42',
            'role' => UserRole::Customer->value,
        ])
        ->assertSessionHasErrors('role');

    expect(User::query()->where('email', 'deguise@example.test')->exists())->toBeFalse();
});

it('lists staff accounts without the customers', function () {
    $keeper = supervisor();
    $shopper = User::factory()->create(['role' => UserRole::Customer, 'name' => 'Cliente ordinaire']);

    $this->actingAs(admin())
        ->get('/admin/utilisateurs')
        ->assertOk()
        ->assertSee($keeper->name)
        ->assertDontSee($shopper->name);
});

it('will not open a customer in the staff editor', function () {
    $shopper = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs(admin())
        ->get("/admin/utilisateurs/{$shopper->id}/edit")
        ->assertNotFound();
});

it('keeps an existing password when the field is left blank', function () {
    $keeper = supervisor();
    $before = $keeper->password;

    $this->actingAs(admin())
        ->patch("/admin/utilisateurs/{$keeper->id}", [
            'name' => 'Nom corrigé',
            'email' => $keeper->email,
            'role' => UserRole::Supervisor->value,
            'password' => '',
        ])
        ->assertSessionHasNoErrors();

    expect($keeper->fresh()->password)->toBe($before)
        ->and($keeper->fresh()->name)->toBe('Nom corrigé');
});

it('refuses to demote the last administrator', function () {
    $only = admin();

    $this->actingAs($only)
        ->patch("/admin/utilisateurs/{$only->id}", [
            'name' => $only->name,
            'email' => $only->email,
            'role' => UserRole::Supervisor->value,
        ])
        ->assertStatus(422);

    expect($only->fresh()->role)->toBe(UserRole::Admin);
});

it('allows demoting an admin while another one remains', function () {
    $staying = admin();
    $leaving = admin();

    $this->actingAs($staying)
        ->patch("/admin/utilisateurs/{$leaving->id}", [
            'name' => $leaving->name,
            'email' => $leaving->email,
            'role' => UserRole::Supervisor->value,
        ])
        ->assertRedirect(route('admin.utilisateurs.index'));

    expect($leaving->fresh()->role)->toBe(UserRole::Supervisor);
});

it('refuses to delete your own account', function () {
    $self = admin();
    admin(); // a second admin, so the refusal is about self-deletion and nothing else

    $this->actingAs($self)
        ->delete("/admin/utilisateurs/{$self->id}")
        ->assertSessionHasErrors('user');

    expect(User::query()->whereKey($self->getKey())->exists())->toBeTrue();
});

it('stops a supervisor from creating accounts', function () {
    $this->actingAs(supervisor())
        ->post('/admin/utilisateurs', [
            'name' => 'Promotion maison',
            'email' => 'maison@example.test',
            'password' => 'mot-de-passe-solide-42',
            'password_confirmation' => 'mot-de-passe-solide-42',
            'role' => UserRole::Admin->value,
        ])
        ->assertForbidden();

    expect(User::query()->where('email', 'maison@example.test')->exists())->toBeFalse();
});
