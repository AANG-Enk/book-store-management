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
                <div class="label">Subtotal Produk</div>
                <div class="value">Rp {{ number_format($totalSubtotalSales ?? 0, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Total Ongkir</div>
                <div class="value">Rp {{ number_format($totalShippingCost ?? 0, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Grand Total</div>
                <div class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
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
                <th>Pengiriman</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Ongkir</th>
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
                    <td>
                        {{ $order->shipping_courier_label }}<br>
                        <span class="muted">{{ $order->tracking_number ? 'Resi: '.$order->tracking_number : $order->shipping_area }}</span>
                    </td>
                    <td class="text-right">Rp {{ number_format((float) $order->subtotal_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format((float) $order->shipping_cost, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dibuat otomatis oleh sistem BookStore.
    </div>
@endsection
