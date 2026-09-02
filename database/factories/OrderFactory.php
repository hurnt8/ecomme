<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 30, 500);
        $shipping = fake()->randomElement([0, 9.99, 24.99]);
        $tax = round($subtotal * 0.2, 2);

        return [
            'order_number' => Order::generateOrderNumber(),
            'user_id' => null,
            'status' => OrderStatus::Pending,
            'paid_at' => null,
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'shipping_address' => fake()->address(),
            'country' => 'FR',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $subtotal + $shipping + $tax,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'status' => OrderStatus::Processing,
            'paid_at' => now(),
        ]);
    }
}
