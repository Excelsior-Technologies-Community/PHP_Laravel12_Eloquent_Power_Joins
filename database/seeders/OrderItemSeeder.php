<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            // Get some products
            $products = Product::take(3)->get();

            foreach ($products as $product) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => rand(1, 5),
                    'price'      => $product->price, // <-- required field
                ]);
            }
        }
    }
}
