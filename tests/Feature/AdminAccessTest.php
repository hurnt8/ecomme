<?php

use App\Enums\UserRole;
use App\Models\User;

it('redirects a guest trying to reach the admin area to the login page', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

it('forbids an authenticated customer from the admin area', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('lets an authenticated admin into the admin area', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

it('sends an admin to the dashboard after login', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin, 'password' => bcrypt('password')]);

    $this->post(route('login'), ['email' => $admin->email, 'password' => 'password'])
        ->assertRedirect(route('admin.dashboard'));
});

it('sends a customer to their account after login', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer, 'password' => bcrypt('password')]);

    $this->post(route('login'), ['email' => $customer->email, 'password' => 'password'])
        ->assertRedirect(route('account.index'));
});

it('forbids a customer from every admin sub-area, not just the dashboard', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)
        ->get(route('admin.produits.index'))
        ->assertForbidden();

    $this->actingAs($customer)
        ->get(route('admin.commandes.index'))
        ->assertForbidden();
});
