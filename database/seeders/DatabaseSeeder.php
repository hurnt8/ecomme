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
            // After ProductSeeder, never before: it rewrites names that seeder has just written,
            // so running it first would leave the catalogue back in French.
            GermanProductNamesSeeder::class,
            GermanProductDescriptionsSeeder::class,
            BannerSeeder::class,
            ReviewSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
