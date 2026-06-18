@extends('layouts.customer')

@section('title', 'Customer Dashboard - BookStore')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Dashboard Customer</h1>
        <p class="text-secondary mb-0">
            Halo, {{ auth()->user()->name }}. Kelola aktivitas belanja buku kamu di sini.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Item Keranjang</p>
                            <h2 class="h4 fw-bold mb-0">{{ $cartItemsCount }}</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-primary">
                            <i class="bi bi-cart"></i>
                        </div>
                    </div>

                    <a href="{{ route('customer.cart.index') }}" class="small stretched-link">
                        Lihat keranjang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Total Pesanan</p>
                            <h2 class="h4 fw-bold mb-0">{{ $ordersCount }}</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-success">
                            <i class="bi bi-bag-check"></i>
                        </div>
                    </div>

                    <a href="{{ route('customer.orders.index') }}" class="small stretched-link">
                        Riwayat pesanan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Katalog Buku</p>
                            <h2 class="h4 fw-bold mb-0">Online</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-info">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>

                    <a href="{{ route('books.index') }}" class="small stretched-link">
                        Mulai belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3 align-items-center mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Pesanan Terbaru</h2>
                            <p class="text-secondary small mb-0">
                                Status pesanan dan pembayaran terakhir.
                            </p>
                        </div>

                        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-primary btn-sm">
                            Semua Pesanan
                        </a>
                    </div>

                    @if ($latestOrders->isEmpty())
                        <div class="text-center py-5">
                            <div class="display-5 text-secondary mb-3">
                                <i class="bi bi-bag"></i>
                            </div>
                            <h3 class="h5 fw-bold">Belum ada pesanan</h3>
                            <p class="text-secondary mb-4">
                                Pilih buku dari katalog lalu lakukan checkout.
                            </p>
                            <a href="{{ route('books.index') }}" class="btn btn-primary">
                                Lihat Katalog
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $order)
                                        <tr>
                                            <td class="fw-semibold">{{ $order->invoice_number }}</td>
                                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $order->formatted_total_price }}</td>
                                            <td>
                                                <span class="badge {{ $order->status_badge_class }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 fw-bold mb-3">Menu Cepat</h2>

                    <div class="d-grid gap-2">
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="bi bi-book me-1"></i>
                            Lihat Katalog
                        </a>

                        <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-cart me-1"></i>
                            Keranjang Saya
                        </a>

                        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-bag-check me-1"></i>
                            Riwayat Pesanan
                        </a>

                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-person me-1"></i>
                            Profil Saya
                        </a>

                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-envelope me-1"></i>
                            Kontak Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
