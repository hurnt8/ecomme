<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'author_name' => fake()->firstName().' '.mb_substr(fake()->lastName(), 0, 1).'.',
            'country' => fake()->randomElement(['FR', 'BE', 'CH', 'CA', 'LU']),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->paragraph(2),
        ];
    }
}
