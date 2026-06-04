<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        // create multiple orders (important for dashboard)
        for ($i = 0; $i < 5; $i++) {

            Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . Str::upper(Str::random(8)),

                // ✅ REQUIRED for your new filter feature
                'status' => ['pending', 'completed', 'cancelled'][array_rand([0,1,2])],
            ]);
        }
    }
}