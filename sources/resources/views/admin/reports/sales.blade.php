@extends('layouts.admin')

@section('title', 'Laporan Penjualan - BookStore')
@section('page_title', 'Laporan Penjualan')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Laporan Penjualan</h1>
            <p class="text-secondary mb-0">
                Data pesanan dan total penjualan berdasarkan filter.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a
                href="{{ route('admin.reports.sales.export', request()->query()) }}"
                class="btn btn-success"
            >
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
            </a>

            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                Kembali ke Laporan
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input
                        id="start_date"
                        type="date"
                        name="start_date"
                        class="form-control"
                        value="{{ $startDate }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input
                        id="end_date"
                        type="date"
                        name="end_date"
                        class="form-control"
                        value="{{ $endDate }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status Order</label>
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

                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Order</p>
                    <h2 class="h4 fw-bold mb-0">{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Penjualan</p>
                    <h2 class="h4 fw-bold mb-0">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($orders->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h2 class="h5 fw-bold">Data penjualan tidak ditemukan</h2>
                    <p class="text-secondary mb-0">
                        Coba ubah filter tanggal atau status order.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-end">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="fw-semibold">{{ $order->invoice_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div>{{ $order->customer_name }}</div>
                                        <div class="small text-secondary">{{ $order->customer_email }}</div>
                                    </td>
                                    <td>{{ $order->items->sum('quantity') }}</td>
                                    <td class="fw-semibold">{{ $order->formatted_total_price }}</td>
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
