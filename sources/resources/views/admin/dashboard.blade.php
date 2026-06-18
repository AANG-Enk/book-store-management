@extends('layouts.admin')

@section('title', 'Admin Dashboard - BookStore')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
        <p class="text-secondary mb-0">
            Ringkasan pengelolaan toko buku, pesanan, pembayaran, stok, dan pesan kontak.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Total Buku</p>
                            <h2 class="h4 fw-bold mb-0">{{ $totalBooks }}</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-primary">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.books.index') }}" class="small stretched-link">
                        Kelola buku
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Total Pesanan</p>
                            <h2 class="h4 fw-bold mb-0">{{ $totalOrders }}</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-success">
                            <i class="bi bi-bag-check"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="small stretched-link">
                        Lihat pesanan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Total Penjualan</p>
                            <h2 class="h5 fw-bold mb-0">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-info">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.sales') }}" class="small stretched-link">
                        Lihat laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 dashboard-stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3">
                        <div>
                            <p class="text-secondary mb-1">Customer</p>
                            <h2 class="h4 fw-bold mb-0">{{ $totalCustomers }}</h2>
                        </div>
                        <div class="dashboard-stat-icon text-bg-secondary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.reports.customers') }}" class="small stretched-link">
                        Lihat customer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="alert alert-warning h-100 mb-0">
                <div class="fw-semibold">Pembayaran Pending</div>
                <div class="display-6 fw-bold">{{ $pendingPayments }}</div>
                <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="alert-link">
                    Verifikasi sekarang
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-danger h-100 mb-0">
                <div class="fw-semibold">Stok Habis</div>
                <div class="display-6 fw-bold">{{ $emptyStockBooks }}</div>
                <a href="{{ route('admin.reports.stocks', ['stock_status' => 'empty']) }}" class="alert-link">
                    Cek stok
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-info h-100 mb-0">
                <div class="fw-semibold">Pesan Belum Dibaca</div>
                <div class="display-6 fw-bold">{{ $unreadContactMessages }}</div>
                <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" class="alert-link">
                    Buka pesan
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3 align-items-center mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Pesanan Terbaru</h2>
                            <p class="text-secondary mb-0 small">
                                5 pesanan terakhir dari customer.
                            </p>
                        </div>

                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-sm">
                            Semua Pesanan
                        </a>
                    </div>

                    @if ($latestOrders->isEmpty())
                        <div class="text-center py-4 text-secondary">
                            Belum ada pesanan.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $order)
                                        <tr>
                                            <td class="fw-semibold">{{ $order->invoice_number }}</td>
                                            <td>
                                                <div>{{ $order->customer_name }}</div>
                                                <div class="small text-secondary">{{ $order->created_at->format('d M Y H:i') }}</div>
                                            </td>
                                            <td>{{ $order->formatted_total_price }}</td>
                                            <td>
                                                <span class="badge {{ $order->status_badge_class }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
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
                    <h2 class="h5 fw-bold mb-3">Shortcut Admin</h2>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Tambah Buku
                        </a>

                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-truck me-1"></i>
                            Kelola Supplier
                        </a>

                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-credit-card me-1"></i>
                            Verifikasi Pembayaran
                        </a>

                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-file-earmark-bar-graph me-1"></i>
                            Buka Laporan
                        </a>

                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1"></i>
                            Lihat Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3 align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Pembayaran Terbaru</h2>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-primary btn-sm">
                            Semua
                        </a>
                    </div>

                    @if ($latestPayments->isEmpty())
                        <div class="text-center py-4 text-secondary">
                            Belum ada pembayaran.
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($latestPayments as $payment)
                                <a
                                    href="{{ route('admin.payments.show', $payment) }}"
                                    class="list-group-item list-group-item-action px-0"
                                >
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $payment->order?->invoice_number ?? '-' }}
                                            </div>
                                            <div class="small text-secondary">
                                                {{ $payment->sender_name }} · {{ $payment->formatted_transfer_amount }}
                                            </div>
                                        </div>
                                        <span class="badge {{ $payment->status_badge_class }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between gap-3 align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Pesan Kontak Terbaru</h2>
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-primary btn-sm">
                            Semua
                        </a>
                    </div>

                    @if ($latestMessages->isEmpty())
                        <div class="text-center py-4 text-secondary">
                            Belum ada pesan kontak.
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($latestMessages as $message)
                                <a
                                    href="{{ route('admin.contact-messages.show', $message) }}"
                                    class="list-group-item list-group-item-action px-0"
                                >
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-semibold">{{ $message->subject }}</div>
                                            <div class="small text-secondary">
                                                {{ $message->name }} · {{ $message->created_at->format('d M Y H:i') }}
                                            </div>
                                        </div>

                                        @if ($message->is_read)
                                            <span class="badge text-bg-success">Dibaca</span>
                                        @else
                                            <span class="badge text-bg-warning">Baru</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
