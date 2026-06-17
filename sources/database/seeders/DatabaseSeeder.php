<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@bookstore.test'],
            [
                'name' => 'Admin BookStore',
                'role' => 'admin',
                'password' => 'password',
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'customer@bookstore.test'],
            [
                'name' => 'Customer Demo',
                'role' => 'customer',
                'password' => 'password',
            ]
        );
    }
}
