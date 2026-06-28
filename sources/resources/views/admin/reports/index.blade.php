@extends('layouts.admin')

@section('title', 'Laporan - BookStore')
@section('page_title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Laporan Admin</h1>
        <p class="text-secondary mb-0">
            Ringkasan laporan penjualan, pembayaran, stok buku, customer, dan ongkir manual.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Penjualan</p>
                    <h2 class="h5 fw-bold mb-1">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </h2>
                    <div class="small text-secondary">
                        Subtotal + ongkir terkonfirmasi.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Subtotal Produk</p>
                    <h2 class="h5 fw-bold mb-1">
                        Rp {{ number_format($totalSubtotalSales ?? 0, 0, ',', '.') }}
                    </h2>
                    <div class="small text-secondary">
                        Nilai produk tanpa ongkir.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Ongkir</p>
                    <h2 class="h5 fw-bold mb-1">
                        Rp {{ number_format($totalShippingCost ?? 0, 0, ',', '.') }}
                    </h2>
                    <div class="small text-secondary">
                        Ongkir manual dari admin.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card content-card h-100">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Pesanan</p>
                    <h2 class="h5 fw-bold mb-1">{{ $totalOrders }}</h2>
                    <div class="small text-secondary">
                        Pembayaran pending: {{ $pendingPayments }}
                    </div>
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
                        Melihat pesanan, subtotal produk, ongkir manual, total akhir, dan status order.
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
