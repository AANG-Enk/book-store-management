@extends('layouts.customer')

@section('title', 'Riwayat Pesanan - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Riwayat Pesanan</h1>
            <p class="text-secondary mb-0">
                Lihat status pesanan, ongkir, pembayaran, dan resi pengiriman.
            </p>
        </div>

        <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-book me-1"></i>
            Belanja Lagi
        </a>
    </div>

    <div class="card content-card">
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3 mx-auto">
                        <i class="bi bi-bag"></i>
                    </div>

                    <h2 class="h5 fw-bold">Belum ada pesanan</h2>
                    <p class="text-secondary mb-4">
                        Pesanan akan tampil setelah kamu melakukan checkout.
                    </p>

                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        Lihat Katalog Buku
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pengiriman</th>
                                <th>Biaya</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $order->invoice_number }}</div>
                                        <div class="small text-secondary">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold small">
                                            {{ $order->shipping_courier_label }}
                                        </div>
                                        <div class="small text-secondary">
                                            {{ $order->shipping_area }}
                                        </div>

                                        @if ($order->tracking_number)
                                            <div class="small mt-1">
                                                <span class="badge text-bg-light border">
                                                    Resi: {{ $order->tracking_number }}
                                                </span>
                                            </div>
                                        @elseif (! $order->is_shipping_confirmed)
                                            <div class="small mt-1 text-warning fw-semibold">
                                                Menunggu ongkir dari admin
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-secondary">
                                            Subtotal: {{ $order->formatted_subtotal_price }}
                                        </div>
                                        <div class="small text-secondary">
                                            Ongkir: {{ $order->formatted_shipping_cost }}
                                        </div>
                                        <div class="fw-semibold">
                                            Total: {{ $order->formatted_total_price }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->status_badge_class }}">
                                            {{ $order->status_label }}
                                        </span>

                                        @if ($order->payment)
                                            <div class="small text-secondary mt-1">
                                                Bayar: {{ $order->payment->status_label }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a
                                            href="{{ route('customer.orders.show', $order) }}"
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
