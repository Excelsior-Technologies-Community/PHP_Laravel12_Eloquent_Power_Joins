<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Storage', 'slug' => 'storage'],
            ['name' => 'Peripherals', 'slug' => 'peripherals'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
