<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('order_items')->delete();
        \DB::table('orders')->delete();
        \DB::table('products')->delete();
        \DB::table('categories')->delete();
        \DB::table('users')->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
