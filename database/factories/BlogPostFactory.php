<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = rtrim($this->faker->sentence(6), '.');

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 9999),
            'excerpt' => $this->faker->sentence(20),
            'body' => implode("\n\n", $this->faker->paragraphs(5)),
            'cover_image' => null,
            'published_at' => $this->faker->boolean(80) ? $this->faker->dateTimeBetween('-6 months') : null,
        ];
    }
}
