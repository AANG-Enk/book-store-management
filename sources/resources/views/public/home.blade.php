<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore - Toko Buku Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-book-half me-2"></i>BookStore
            </a>

            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <section class="page-section bg-white">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <span class="badge text-bg-primary mb-3">Toko Buku Online</span>
                        <h1 class="display-5 fw-bold mb-3">
                            Temukan Buku Favoritmu dengan Mudah
                        </h1>
                        <p class="lead text-secondary mb-4">
                            BookStore menyediakan berbagai kategori buku untuk kebutuhan belajar,
                            referensi, dan bacaan harian.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Mulai Belanja
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                Lihat Katalog
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-5">
                                <div class="display-1 text-primary mb-3">
                                    <i class="bi bi-bookshelf"></i>
                                </div>
                                <h2 class="h4 fw-bold">Katalog Buku Lengkap</h2>
                                <p class="text-secondary mb-0">
                                    Modul katalog, keranjang, checkout, pembayaran manual,
                                    dan laporan penjualan akan dibuat bertahap.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Fitur Utama</h2>
                    <p class="text-secondary">Sesuai kebutuhan website toko buku mahasiswa.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-search fs-2 text-primary"></i>
                                <h3 class="h5 mt-3">Katalog Buku</h3>
                                <p class="text-secondary mb-0">
                                    Customer dapat melihat daftar buku dan detail buku.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-cart-check fs-2 text-primary"></i>
                                <h3 class="h5 mt-3">Keranjang & Checkout</h3>
                                <p class="text-secondary mb-0">
                                    Alur belanja dari keranjang sampai pesanan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-receipt fs-2 text-primary"></i>
                                <h3 class="h5 mt-3">Pembayaran Manual</h3>
                                <p class="text-secondary mb-0">
                                    Customer upload bukti transfer dan admin melakukan verifikasi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-white border-top py-4">
            <div class="container text-center text-secondary small">
                &copy; {{ date('Y') }} BookStore. Website Toko Buku.
            </div>
        </footer>
    </main>
</body>
</html>
