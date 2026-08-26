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
        $users = User::all();
        $statuses = ['pending', 'completed', 'cancelled'];

        foreach ($users as $user) {
            $orderCount = rand(2, 5);
            for ($i = 0; $i < $orderCount; $i++) {
                Order::create([
                    'user_id' => $user->id,
                    'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                    'status' => $statuses[array_rand($statuses)],
                    'total_amount' => 0,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}
