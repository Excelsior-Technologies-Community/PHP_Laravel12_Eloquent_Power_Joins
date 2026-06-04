<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Laptop',
                'price' => 50000
            ],
            [
                'name' => 'Mouse',
                'price' => 1000
            ],
            [
                'name' => 'Keyboard',
                'price' => 1500
            ],
            [
                'name' => 'Monitor',
                'price' => 12000
            ],
        ]);
    }
}