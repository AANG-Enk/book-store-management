@extends('admin.reports.pdf._layout', ['title' => 'Laporan Penjualan'])

@section('content')
    <div class="header">
        <div class="brand">BookStore</div>
        <h1>Laporan Penjualan</h1>
        <p class="muted">
            Dicetak pada {{ now()->format('d/m/Y H:i') }}
            @if ($startDate || $endDate)
                | Periode: {{ $startDate ?: '-' }} s/d {{ $endDate ?: '-' }}
            @endif
        </p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Order</div>
                <div class="value">{{ $totalOrders }}</div>
            </td>
            <td>
                <div class="label">Total Penjualan</div>
                <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Filter Status</div>
                <div class="value">{{ $status ?: 'Semua' }}</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th class="text-center">Item</th>
                <th class="text-right">Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $order->customer_name }}<br>
                        <span class="muted">{{ $order->customer_email }}</span>
                    </td>
                    <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                    <td class="text-right">Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dibuat otomatis oleh sistem BookStore.
    </div>
@endsection
