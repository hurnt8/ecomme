<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

it('sends a reset link for a known e-mail without revealing whether the account exists', function () {
    Notification::fake();
    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email])
        ->assertSessionDoesntHaveErrors();

    $this->post(route('password.email'), ['email' => 'nobody@example.com'])
        ->assertSessionDoesntHaveErrors();

    Notification::assertSentTo($user, ResetPassword::class);
});

it('resets the password with a valid token and logs in with the new one', function () {
    $user = User::factory()->create(['password' => bcrypt('OldPassword123')]);
    $token = Password::createToken($user);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'BrandNewPassword456',
        'password_confirmation' => 'BrandNewPassword456',
    ])->assertRedirect(route('login'));

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'BrandNewPassword456',
    ])->assertRedirect();

    expect(auth()->check())->toBeTrue();
});

it('rejects a reset with an invalid token', function () {
    $user = User::factory()->create();

    $this->post(route('password.update'), [
        'token' => 'not-a-real-token',
        'email' => $user->email,
        'password' => 'BrandNewPassword456',
        'password_confirmation' => 'BrandNewPassword456',
    ])->assertSessionHasErrors('email');
});
