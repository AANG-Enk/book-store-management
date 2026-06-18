@extends('layouts.admin')

@section('title', 'Laporan - BookStore')
@section('page_title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Laporan Admin</h1>
        <p class="text-secondary mb-0">
            Ringkasan laporan penjualan, pembayaran, stok buku, dan customer.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Penjualan</p>
                    <h2 class="h5 fw-bold mb-0">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Pesanan</p>
                    <h2 class="h5 fw-bold mb-0">{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Pembayaran Pending</p>
                    <h2 class="h5 fw-bold mb-0">{{ $pendingPayments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Customer</p>
                    <h2 class="h5 fw-bold mb-0">{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card content-card h-100">
                <div class="card-body p-4">
                    <div class="fs-2 text-primary mb-3">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h2 class="h5 fw-bold">Laporan Penjualan</h2>
                    <p class="text-secondary">
                        Melihat daftar pesanan, total penjualan, dan status order.
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-primary btn-sm">
                            Buka Laporan
                        </a>

                        <a href="{{ route('admin.reports.sales.export') }}" class="btn btn-outline-success btn-sm">
                            Export Excel
                        </a>

                        <a href="{{ route('admin.reports.sales.pdf') }}" class="btn btn-outline-danger btn-sm" target="_blank">
                            PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card content-card h-100">
                <div class="card-body p-4">
                    <div class="fs-2 text-primary mb-3">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h2 class="h5 fw-bold">Laporan Pembayaran</h2>
                    <p class="text-secondary">
                        Memantau bukti transfer, nominal pembayaran, dan status verifikasi.
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.payments') }}" class="btn btn-primary btn-sm">
                            Buka Laporan
                        </a>

                        <a href="{{ route('admin.reports.payments.export') }}" class="btn btn-outline-success btn-sm">
                            Export Excel
                        </a>

                        <a href="{{ route('admin.reports.payments.pdf') }}" class="btn btn-outline-danger btn-sm" target="_blank">
                            PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card content-card h-100">
                <div class="card-body p-4">
                    <div class="fs-2 text-primary mb-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h2 class="h5 fw-bold">Laporan Stok Buku</h2>
                    <p class="text-secondary">
                        Melihat buku stok aman, stok menipis, dan stok habis.
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.stocks') }}" class="btn btn-primary btn-sm">
                            Buka Laporan
                        </a>

                        <a href="{{ route('admin.reports.stocks.export') }}" class="btn btn-outline-success btn-sm">
                            Export Excel
                        </a>

                        <a href="{{ route('admin.reports.stocks.pdf') }}" class="btn btn-outline-danger btn-sm" target="_blank">
                            PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card content-card h-100">
                <div class="card-body p-4">
                    <div class="fs-2 text-primary mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h2 class="h5 fw-bold">Laporan Customer</h2>
                    <p class="text-secondary">
                        Melihat daftar customer, jumlah order, dan total belanja.
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.reports.customers') }}" class="btn btn-primary btn-sm">
                            Buka Laporan
                        </a>

                        <a href="{{ route('admin.reports.customers.export') }}" class="btn btn-outline-success btn-sm">
                            Export Excel
                        </a>

                        <a href="{{ route('admin.reports.customers.pdf') }}" class="btn btn-outline-danger btn-sm" target="_blank">
                            PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
