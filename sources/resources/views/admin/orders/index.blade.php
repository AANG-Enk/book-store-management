@extends('layouts.admin')

@section('title', 'Pesanan - BookStore')
@section('page_title', 'Pesanan')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Pesanan</h1>
            <p class="text-secondary mb-0">
                Kelola pesanan customer dari checkout sampai selesai.
            </p>
        </div>
    </div>

    <div class="card content-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Invoice, nama customer, email, no telepon"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua Status</option>

                        @foreach ($statuses as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" @selected($status === $statusKey)>
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card content-card">
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3 mx-auto">
                        <i class="bi bi-bag-check"></i>
                    </div>

                    <h2 class="h5 fw-bold">Belum ada pesanan</h2>
                    <p class="text-secondary mb-0">
                        Pesanan customer akan tampil setelah checkout.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Status Order</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $order->invoice_number }}</div>
                                        <div class="small text-secondary">
                                            ID: #{{ $order->id }}
                                        </div>
                                    </td>

                                    <td>
                                        <div>{{ $order->customer_name }}</div>
                                        <div class="small text-secondary">
                                            {{ $order->customer_email }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $order->formatted_total_price }}
                                    </td>

                                    <td>
                                        @if ($order->payment)
                                            <span class="badge {{ $order->payment->status_badge_class }}">
                                                {{ $order->payment->status_label }}
                                            </span>
                                        @else
                                            <span class="badge text-bg-secondary">
                                                Belum Upload
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge {{ $order->status_badge_class }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
