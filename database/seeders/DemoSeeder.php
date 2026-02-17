<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $user = User::create([
        'name' => 'Amit Patel',
        'email' => 'amit@test.com'
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'order_no' => 'ORD-1001'
    ]);

    $product1 = Product::create([
        'title' => 'Laptop',
        // 'price' => 55000
    ]);

    $product2 = Product::create([
        'title' => 'Mouse',
        // 'price' => 1200
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product1->id,
        'quantity' => 1
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product2->id,
        'quantity' => 2
    ]);
}

}
