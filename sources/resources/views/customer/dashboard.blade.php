@extends('layouts.customer')

@section('title', 'Dashboard Customer - BookStore')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold">Dashboard Customer</h1>
        <p class="text-secondary mb-0">
            Selamat datang, {{ auth()->user()->name }}.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-search fs-2 text-primary"></i>
                    <h2 class="h5 mt-3">Lihat Katalog</h2>
                    <p class="text-secondary">
                        Cari buku berdasarkan kategori dan judul.
                    </p>
                    <a href="#" class="btn btn-primary btn-sm disabled">
                        Segera Dibuat
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-cart fs-2 text-primary"></i>
                    <h2 class="h5 mt-3">Keranjang</h2>
                    <p class="text-secondary">
                        Simpan buku sebelum melakukan checkout.
                    </p>
                    <a href="#" class="btn btn-primary btn-sm disabled">
                        Segera Dibuat
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="bi bi-clock-history fs-2 text-primary"></i>
                    <h2 class="h5 mt-3">Riwayat Pesanan</h2>
                    <p class="text-secondary">
                        Lihat status pesanan dan pembayaran.
                    </p>
                    <a href="#" class="btn btn-primary btn-sm disabled">
                        Segera Dibuat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5 fw-bold mb-3">Informasi Akun</h2>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-secondary small">Nama</div>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                </div>

                <div class="col-md-4">
                    <div class="text-secondary small">Email</div>
                    <div class="fw-semibold">{{ auth()->user()->email }}</div>
                </div>

                <div class="col-md-4">
                    <div class="text-secondary small">Role</div>
                    <div class="fw-semibold text-capitalize">{{ auth()->user()->role }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
