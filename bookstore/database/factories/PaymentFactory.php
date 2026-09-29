<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Membuat data contoh pembayaran simulasi.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'payment_code' => 'PAY-'.fake()->unique()->numerify('############'),
            'method' => Payment::METHOD_SIMULATION,
            'amount' => fake()->numberBetween(50000, 1000000),
            'status' => 'success',
            'paid_at' => now(),
        ];
    }
}
