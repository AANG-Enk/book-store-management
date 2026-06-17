@extends('layouts.admin')

@section('title', 'Dashboard Admin - BookStore')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold">Dashboard Admin</h1>
        <p class="text-secondary mb-0">
            Ringkasan data toko buku akan tampil di halaman ini.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary mb-1">Total Buku</p>
                            <h2 class="h4 fw-bold mb-0">0</h2>
                        </div>
                        <i class="bi bi-book fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary mb-1">Total Customer</p>
                            <h2 class="h4 fw-bold mb-0">0</h2>
                        </div>
                        <i class="bi bi-people fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary mb-1">Total Pesanan</p>
                            <h2 class="h4 fw-bold mb-0">0</h2>
                        </div>
                        <i class="bi bi-bag-check fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary mb-1">Pembayaran Pending</p>
                            <h2 class="h4 fw-bold mb-0">0</h2>
                        </div>
                        <i class="bi bi-credit-card fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5 fw-bold mb-3">Tahap Pengembangan</h2>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Modul</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Auth & Role</td>
                            <td><span class="badge text-bg-success">Selesai</span></td>
                            <td>Login, register, admin, dan customer sudah aktif.</td>
                        </tr>
                        <tr>
                            <td>Master Kategori</td>
                            <td><span class="badge text-bg-warning">Berikutnya</span></td>
                            <td>CRUD kategori buku untuk admin.</td>
                        </tr>
                        <tr>
                            <td>Master Buku</td>
                            <td><span class="badge text-bg-secondary">Belum</span></td>
                            <td>Data buku, stok, harga, gambar, dan kategori.</td>
                        </tr>
                        <tr>
                            <td>Transaksi</td>
                            <td><span class="badge text-bg-secondary">Belum</span></td>
                            <td>Keranjang, checkout, pembayaran, dan pesanan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
