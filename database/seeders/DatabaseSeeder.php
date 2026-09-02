<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Note: this seeder does NOT use WithoutModelEvents — Order relies on a
     * `creating` model event to generate its order_number.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BannerSeeder::class,
            ReviewSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
