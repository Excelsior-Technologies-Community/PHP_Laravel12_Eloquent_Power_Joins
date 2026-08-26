<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Amit Patel',
            'email' => 'amit@test.com',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-1001',
            'status' => 'completed',
        ]);

        $product1 = Product::create([
            'name' => 'Laptop',
            'price' => 55000,
            'stock' => 10,
        ]);

        $product2 = Product::create([
            'name' => 'Mouse',
            'price' => 1200,
            'stock' => 25,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'price' => $product1->price,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 2,
            'price' => $product2->price,
        ]);
    }
}
