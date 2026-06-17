<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Supplier;
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

        $bookSeeds = [
            [
                'category_slug' => 'novel',
                'supplier_name' => 'Gramedia Distributor',
                'title' => 'Laskar Pelangi',
                'slug' => 'laskar-pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'isbn' => '9789793062792',
                'description' => 'Novel populer Indonesia tentang perjuangan anak-anak Belitung dalam meraih pendidikan.',
                'stock' => 12,
                'price' => 85000,
                'is_active' => true,
            ],
            [
                'category_slug' => 'pendidikan',
                'supplier_name' => 'Gramedia Distributor',
                'title' => 'Dasar-Dasar Pemrograman Web',
                'slug' => 'dasar-dasar-pemrograman-web',
                'author' => 'Tim BookStore',
                'publisher' => 'BookStore Press',
                'publication_year' => 2024,
                'isbn' => '9786020000001',
                'description' => 'Buku pengantar HTML, CSS, JavaScript, dan konsep dasar pengembangan website.',
                'stock' => 8,
                'price' => 95000,
                'is_active' => true,
            ],
            [
                'category_slug' => 'bisnis',
                'supplier_name' => 'Gramedia Distributor',
                'title' => 'Manajemen Bisnis untuk Pemula',
                'slug' => 'manajemen-bisnis-untuk-pemula',
                'author' => 'Raka Pratama',
                'publisher' => 'Nusantara Media',
                'publication_year' => 2023,
                'isbn' => '9786020000002',
                'description' => 'Panduan dasar memahami bisnis, pemasaran, keuangan, dan operasional usaha.',
                'stock' => 4,
                'price' => 78000,
                'is_active' => true,
            ],
            [
                'category_slug' => 'komik',
                'supplier_name' => 'Gramedia Distributor',
                'title' => 'Petualangan Si Kancil',
                'slug' => 'petualangan-si-kancil',
                'author' => 'Budi Santoso',
                'publisher' => 'Ceria Anak',
                'publication_year' => 2022,
                'isbn' => '9786020000003',
                'description' => 'Komik ringan untuk anak-anak dengan cerita edukatif dan ilustrasi menarik.',
                'stock' => 0,
                'price' => 45000,
                'is_active' => true,
            ],
        ];

        foreach ($bookSeeds as $bookSeed) {
            $category = Category::query()
                ->where('slug', $bookSeed['category_slug'])
                ->first();

            if (! $category) {
                continue;
            }

            $supplier = null;

            if (! empty($bookSeed['supplier_name'])) {
                $supplier = Supplier::query()
                    ->where('name', $bookSeed['supplier_name'])
                    ->first();
            }

            unset($bookSeed['category_slug'], $bookSeed['supplier_name']);

            Book::query()->firstOrCreate(
                ['slug' => $bookSeed['slug']],
                array_merge($bookSeed, [
                    'category_id' => $category->id,
                    'supplier_id' => $supplier?->id,
                ])
            );
        }

        $suppliers = [
            [
                'name' => 'Gramedia Distributor',
                'phone' => '0215551001',
                'email' => 'supplier@gramedia.test',
                'address' => 'Jl. Buku Nasional No. 1, Jakarta',
                'notes' => 'Supplier utama untuk buku populer dan pendidikan.',
                'is_active' => true,
            ],
            [
                'name' => 'Nusantara Book Supply',
                'phone' => '0225552002',
                'email' => 'sales@nusantarabook.test',
                'address' => 'Jl. Merdeka No. 20, Bandung',
                'notes' => 'Supplier buku lokal dan komik.',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::query()->firstOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}
