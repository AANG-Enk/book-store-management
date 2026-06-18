@extends('layouts.public')

@section('title', 'Tentang Kami - BookStore')

@section('content')
    <section class="py-5 soft-panel border-bottom">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="badge text-bg-primary mb-3">Tentang BookStore</span>

                    <h1 class="display-6 fw-bold mb-3">
                        Toko Buku Online untuk Kebutuhan Bacaan dan Belajar
                    </h1>

                    <p class="lead text-secondary mb-0">
                        BookStore adalah website toko buku online yang menyediakan katalog buku,
                        informasi stok, keranjang belanja, checkout, pembayaran manual, dan laporan admin.
                    </p>
                </div>

                <div class="col-lg-5">
                    <div class="card content-card">
                        <div class="card-body p-5 text-center">
                            <div class="display-1 text-primary mb-3">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <h2 class="h4 fw-bold">BookStore</h2>
                            <p class="text-secondary mb-0">
                                Sistem informasi penjualan buku berbasis Laravel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card content-card h-100">
                        <div class="card-body p-4">
                            <i class="bi bi-search fs-2 text-primary"></i>
                            <h2 class="h5 fw-bold mt-3">Katalog Mudah Dicari</h2>
                            <p class="text-secondary mb-0">
                                Pengunjung dapat mencari buku berdasarkan judul, penulis, penerbit, ISBN, dan kategori.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card content-card h-100">
                        <div class="card-body p-4">
                            <i class="bi bi-cart-check fs-2 text-primary"></i>
                            <h2 class="h5 fw-bold mt-3">Belanja Bertahap</h2>
                            <p class="text-secondary mb-0">
                                Customer dapat menambahkan buku ke keranjang lalu checkout saat data pesanan sudah sesuai.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card content-card h-100">
                        <div class="card-body p-4">
                            <i class="bi bi-clipboard-data fs-2 text-primary"></i>
                            <h2 class="h5 fw-bold mt-3">Admin Terstruktur</h2>
                            <p class="text-secondary mb-0">
                                Admin dapat mengelola kategori, supplier, buku, stok, pesanan, pembayaran, dan laporan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card content-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-8">
                            <h2 class="h4 fw-bold mb-3">Tujuan Website</h2>
                            <p class="text-secondary mb-0">
                                Website ini dibuat sebagai sistem toko buku sederhana yang membantu proses
                                pengelolaan data buku, transaksi customer, pembayaran manual, serta laporan admin.
                                Sistem ini cocok untuk studi kasus tugas mahasiswa karena memiliki alur public,
                                customer, dan admin yang lengkap.
                            </p>
                        </div>

                        <div class="col-lg-4">
                            <a href="{{ route('books.index') }}" class="btn btn-primary w-100 mb-2">
                                Lihat Katalog Buku
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
