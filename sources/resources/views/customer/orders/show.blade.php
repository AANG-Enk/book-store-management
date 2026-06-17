@extends('layouts.customer')

@section('title', 'Detail Pesanan ' . $order->invoice_number . ' - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pesanan</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold">{{ $order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
            Kembali ke Riwayat
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Item Pesanan</h2>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $item->book_title }}</div>
                                            @if ($item->book)
                                                <div class="small text-secondary">
                                                    {{ $item->book->category?->name ?? '-' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item->formatted_book_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">
                                            {{ $item->formatted_subtotal }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end text-primary">
                                        {{ $order->formatted_total_price }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Informasi Pengiriman</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $order->customer_name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $order->customer_email }}</dd>

                        <dt class="col-sm-4">No. Telepon</dt>
                        <dd class="col-sm-8">{{ $order->customer_phone ?: '-' }}</dd>

                        <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->shipping_address }}</dd>

                        <dt class="col-sm-4">Catatan</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->notes ?: '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Status Pesanan</h2>

                    <div class="mb-3">
                        <span class="badge {{ $order->status_badge_class }}">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <div class="small text-secondary mb-2">Tanggal Pesanan</div>
                    <div class="fw-semibold mb-3">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </div>

                    <div class="small text-secondary mb-2">Total Pembayaran</div>
                    <div class="h5 fw-bold text-primary mb-0">
                        {{ $order->formatted_total_price }}
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <div class="fw-semibold mb-1">Pembayaran Manual</div>
                <div class="small">
                    Modul upload bukti pembayaran dan verifikasi admin akan dibuat pada tahap berikutnya.
                </div>
            </div>
        </div>
    </div>
@endsection
