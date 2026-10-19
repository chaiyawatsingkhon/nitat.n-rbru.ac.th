<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Category::factory(10)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Customer::factory(100)->create();
        
        $orders = \App\Models\Order::factory(150)->create();

        foreach ($orders as $order) {
            $itemsCount = rand(1, 5);
            $items = \App\Models\OrderItem::factory($itemsCount)->create(['order_id' => $order->id]);
            
            $totalAmount = $items->sum(function($item) {
                return $item->quantity * $item->price;
            });

            $order->update(['total_amount' => $totalAmount]);

            \App\Models\Payment::factory()->create([
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'paid_at' => $order->status === 'completed' ? clone $order->order_date->modify('+1 day') : null
            ]);
        }
    }
}
