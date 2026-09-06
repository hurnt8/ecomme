<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * The demo administrator's address changed with the shop's name. Rename the account that
     * already exists rather than letting updateOrCreate() below miss it on the new address and
     * open a second one: the original admin owns order history, and a shop with two
     * administrators — one of them still branded for the previous trade — is worse than either.
     */
    private const LEGACY_EMAIL = 'admin@atelier-maison.test';

    private const EMAIL = 'admin@sillon-buche.test';

    public function run(): void
    {
        if (! User::query()->where('email', self::EMAIL)->exists()) {
            User::query()->where('email', self::LEGACY_EMAIL)->update(['email' => self::EMAIL]);
        }

        User::query()->updateOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );
    }
}
