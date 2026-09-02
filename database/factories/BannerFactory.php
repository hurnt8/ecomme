<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'subtitle' => fake()->sentence(8),
            'image' => 'banners/placeholder.jpg',
            'link_url' => '/boutique',
            'position' => fake()->randomElement(Banner::POSITIONS),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 5),
        ];
    }
}
