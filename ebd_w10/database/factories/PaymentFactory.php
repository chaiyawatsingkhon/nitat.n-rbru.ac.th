<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id ?? \App\Models\Order::factory(),
            'payment_method' => fake()->randomElement(['credit_card', 'bank_transfer', 'cod', 'paypal']),
            'amount' => 0, // Will be updated by seeder
            'paid_at' => fake()->dateTimeBetween('-12 months', 'now'),
        ];
    }
}
