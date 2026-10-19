<?php

namespace Database\Factories;

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
        return [
            'customer_id' => \App\Models\Customer::inRandomOrder()->first()->id ?? \App\Models\Customer::factory(),
            'order_date' => fake()->dateTimeBetween('-12 months', 'now'),
            'total_amount' => 0, // Will be updated by seeder after adding items
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
        ];
    }
}
