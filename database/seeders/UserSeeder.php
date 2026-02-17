<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks and delete rows
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('users')->delete();
        \DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create random users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Random User ' . $i,
                'email' => 'user' . now()->timestamp . $i . '@test.com',
                // 'password' => Hash::make('secret123'),
            ]);
        }

        // Fixed user
        User::updateOrCreate(
            ['email' => 'rahul@test.com'],
            [
                'name' => 'Rahul Patel',
                // 'password' => Hash::make('secret123'),
            ]
        );
    }
}
