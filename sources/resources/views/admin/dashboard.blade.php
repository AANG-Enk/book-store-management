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
                            <h2 class="h4 fw-bold mb-0">{{ $totalBooks }}</h2>
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
                            <h2 class="h4 fw-bold mb-0">{{ $totalCustomers }}</h2>
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
                            <h2 class="h4 fw-bold mb-0">{{ $totalOrders }}</h2>
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
                            <h2 class="h4 fw-bold mb-0">{{ $pendingPayments }}</h2>
                        </div>
                        <i class="bi bi-credit-card fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 fw-bold">Manajemen Pesanan</h2>
                    <p class="text-secondary">
                        Lihat pesanan terbaru, cek status pembayaran, dan proses order customer.
                    </p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">
                        Buka Pesanan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 fw-bold">Verifikasi Pembayaran</h2>
                    <p class="text-secondary">
                        Periksa bukti transfer customer dan verifikasi pembayaran manual.
                    </p>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-primary btn-sm">
                        Buka Pembayaran
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 fw-bold">Laporan Admin</h2>
                    <p class="text-secondary">
                        Lihat laporan penjualan, pembayaran, stok buku, dan customer.
                    </p>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">
                        Buka Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
