<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Membuat data contoh pesanan.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => Order::NUMBER_PREFIX.fake()->unique()->numerify('############'),
            'status' => OrderStatus::Pending,
            'total_price' => fake()->numberBetween(50000, 1000000),
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->numerify('08##########'),
            'shipping_address' => fake()->address(),
            'note' => null,
            'paid_at' => null,
        ];
    }

    /**
     * Menandai pesanan sudah dibayar.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => OrderStatus::Paid,
            'paid_at' => now(),
        ]);
    }
}
