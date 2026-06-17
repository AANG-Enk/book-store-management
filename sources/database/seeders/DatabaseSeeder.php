<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
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

        $categories = [
            [
                'name' => 'Novel',
                'slug' => 'novel',
                'description' => 'Kumpulan buku cerita fiksi dan sastra.',
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Buku pelajaran, akademik, dan referensi belajar.',
                'is_active' => true,
            ],
            [
                'name' => 'Komik',
                'slug' => 'komik',
                'description' => 'Buku komik dan bacaan bergambar.',
                'is_active' => true,
            ],
            [
                'name' => 'Bisnis',
                'slug' => 'bisnis',
                'description' => 'Buku bisnis, manajemen, dan pengembangan diri.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
