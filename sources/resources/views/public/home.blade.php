@extends('layouts.public')

@section('title', 'BookStore - Toko Buku Online')

@section('content')
    <section class="hero-section bg-white border-bottom">
        <div class="container py-5">
            <div class="row align-items-center g-5 py-lg-5">
                <div class="col-lg-6">
                    <span class="badge text-bg-primary mb-3">Toko Buku Online</span>

                    <h1 class="display-5 fw-bold mb-3">
                        Temukan Buku Pilihan dengan Belanja yang Lebih Mudah
                    </h1>

                    <p class="lead text-secondary mb-4">
                        BookStore menyediakan katalog buku, pencarian berdasarkan kategori,
                        keranjang belanja, checkout, pembayaran manual, dan riwayat pesanan customer.
                    </p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">
                            Lihat Katalog
                        </a>

                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                Daftar Customer
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg">
                                Dashboard
                            </a>
                        @endguest

                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-lg">
                            Kontak
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="mini-book-card bg-primary text-white">
                                        <i class="bi bi-book fs-1"></i>
                                        <div class="fw-bold mt-3">Katalog Buku</div>
                                        <div class="small opacity-75">Cari buku favorit</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-book-card bg-light">
                                        <i class="bi bi-cart-check fs-1 text-primary"></i>
                                        <div class="fw-bold mt-3">Keranjang</div>
                                        <div class="small text-secondary">Belanja bertahap</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-book-card bg-light">
                                        <i class="bi bi-credit-card fs-1 text-primary"></i>
                                        <div class="fw-bold mt-3">Pembayaran</div>
                                        <div class="small text-secondary">Upload bukti transfer</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mini-book-card bg-dark text-white">
                                        <i class="bi bi-file-earmark-bar-graph fs-1"></i>
                                        <div class="fw-bold mt-3">Laporan</div>
                                        <div class="small opacity-75">Admin lengkap</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h1 fw-bold">Fitur Utama BookStore</h2>
                <p class="text-secondary mb-0">
                    Website dibuat dengan alur public, customer, dan admin yang lengkap.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 feature-card">
                        <div class="card-body p-4">
                            <i class="bi bi-search fs-2 text-primary"></i>
                            <h3 class="h5 fw-bold mt-3">Katalog & Pencarian</h3>
                            <p class="text-secondary mb-0">
                                Pengunjung dapat melihat buku, mencari berdasarkan kata kunci,
                                dan memfilter berdasarkan kategori.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 feature-card">
                        <div class="card-body p-4">
                            <i class="bi bi-cart-check fs-2 text-primary"></i>
                            <h3 class="h5 fw-bold mt-3">Keranjang & Checkout</h3>
                            <p class="text-secondary mb-0">
                                Customer dapat menambahkan buku ke keranjang, checkout,
                                dan melihat riwayat pesanan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 feature-card">
                        <div class="card-body p-4">
                            <i class="bi bi-speedometer2 fs-2 text-primary"></i>
                            <h3 class="h5 fw-bold mt-3">Dashboard Admin</h3>
                            <p class="text-secondary mb-0">
                                Admin dapat mengelola buku, supplier, stok, pesanan,
                                pembayaran, pesan kontak, dan laporan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </section>

    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <h2 class="h1 fw-bold mb-3">Alur Belanja Sederhana</h2>
                    <p class="text-secondary mb-0">
                        Customer cukup memilih buku, memasukkan ke keranjang, checkout,
                        lalu upload bukti pembayaran manual.
                    </p>
                </div>

                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="process-item">
                                <span>1</span>
                                <div>
                                    <h3 class="h6 fw-bold mb-1">Pilih Buku</h3>
                                    <p class="small text-secondary mb-0">Buka katalog dan lihat detail buku.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="process-item">
                                <span>2</span>
                                <div>
                                    <h3 class="h6 fw-bold mb-1">Masukkan Keranjang</h3>
                                    <p class="small text-secondary mb-0">Atur jumlah buku sesuai stok tersedia.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="process-item">
                                <span>3</span>
                                <div>
                                    <h3 class="h6 fw-bold mb-1">Checkout</h3>
                                    <p class="small text-secondary mb-0">Isi data pengiriman dan buat pesanan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="process-item">
                                <span>4</span>
                                <div>
                                    <h3 class="h6 fw-bold mb-1">Upload Pembayaran</h3>
                                    <p class="small text-secondary mb-0">Admin akan memverifikasi bukti transfer.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4 p-lg-5 text-center">
                    <h2 class="h1 fw-bold mb-3">Mulai Cari Buku Sekarang</h2>
                    <p class="lead opacity-75 mb-4">
                        Lihat katalog buku yang tersedia dan lakukan pemesanan dengan mudah.
                    </p>

                    <a href="{{ route('books.index') }}" class="btn btn-light btn-lg">
                        Buka Katalog
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
