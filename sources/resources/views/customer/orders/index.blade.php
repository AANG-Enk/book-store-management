@extends('layouts.customer')

@section('title', 'Riwayat Pesanan - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Riwayat Pesanan</h1>
            <p class="text-secondary mb-0">
                Lihat daftar pesanan yang pernah kamu buat.
            </p>
        </div>

        <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-book me-1"></i>
            Belanja Lagi
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
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
                                <th>Tanggal</th>
                                <th>Total</th>
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
                                            {{ $order->customer_name }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="fw-semibold">
                                        {{ $order->formatted_total_price }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $order->status_badge_class }}">
                                            {{ $order->status_label }}
                                        </span>
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
