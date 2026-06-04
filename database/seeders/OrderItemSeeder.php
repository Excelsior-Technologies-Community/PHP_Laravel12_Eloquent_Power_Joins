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
        $products = Product::all();

        foreach ($orders as $order) {

            // attach random 2–3 products per order
            $randomProducts = $products->random(rand(2, 3));

            foreach ($randomProducts as $product) {

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => rand(1, 5),

                    // ✅ required for total calculation
                    'price'      => $product->price,
                ]);
            }
        }
    }
}