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

        Order::create([
            'user_id' => $user->id,
            // 'total' => 55500,
             'order_number' => 'ORD-' . Str::random(8),
        ]);
    }
}
