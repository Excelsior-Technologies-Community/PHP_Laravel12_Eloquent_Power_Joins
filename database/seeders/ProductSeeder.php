<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $accessories = Category::where('slug', 'accessories')->first();
        $storage = Category::where('slug', 'storage')->first();
        $peripherals = Category::where('slug', 'peripherals')->first();

        Product::insert([
            ['name' => 'Laptop', 'price' => 50000, 'stock' => 25, 'category_id' => $electronics?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mouse', 'price' => 1000, 'stock' => 150, 'category_id' => $peripherals?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Keyboard', 'price' => 1500, 'stock' => 80, 'category_id' => $peripherals?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Monitor', 'price' => 12000, 'stock' => 30, 'category_id' => $electronics?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SSD 1TB', 'price' => 5000, 'stock' => 45, 'category_id' => $storage?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Headphones', 'price' => 2500, 'stock' => 60, 'category_id' => $accessories?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Webcam', 'price' => 3000, 'stock' => 35, 'category_id' => $accessories?->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'USB Hub', 'price' => 800, 'stock' => 100, 'category_id' => $accessories?->id, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
