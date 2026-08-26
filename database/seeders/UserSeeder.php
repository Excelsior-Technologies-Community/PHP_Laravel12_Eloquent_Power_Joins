<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Rahul Patel', 'email' => 'rahul@test.com'],
            ['name' => 'Priya Sharma', 'email' => 'priya@test.com'],
            ['name' => 'Amit Kumar', 'email' => 'amit@test.com'],
            ['name' => 'Sneha Joshi', 'email' => 'sneha@test.com'],
            ['name' => 'Vikram Singh', 'email' => 'vikram@test.com'],
            ['name' => 'Neha Gupta', 'email' => 'neha@test.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
            ]);
        }
    }
}
