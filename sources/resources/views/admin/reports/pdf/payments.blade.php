@extends('admin.reports.pdf._layout', ['title' => 'Laporan Pembayaran'])

@section('content')
    <div class="header">
        <div class="brand">BookStore</div>
        <h1>Laporan Pembayaran</h1>
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
                <div class="label">Total Pembayaran</div>
                <div class="value">{{ $totalPayments }}</div>
            </td>
            <td>
                <div class="label">Total Nominal Transfer</div>
                <div class="value">Rp {{ number_format($totalTransfer, 0, ',', '.') }}</div>
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
                <th>Tanggal Upload</th>
                <th>Customer</th>
                <th>Pengirim</th>
                <th>Bank</th>
                <th class="text-right">Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $payment->order?->invoice_number ?? '-' }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $payment->order?->customer_name ?? '-' }}<br>
                        <span class="muted">{{ $payment->order?->customer_email ?? '-' }}</span>
                    </td>
                    <td>{{ $payment->sender_name }}</td>
                    <td>{{ $payment->bank_name ?: '-' }}</td>
                    <td class="text-right">Rp {{ number_format((float) $payment->transfer_amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dibuat otomatis oleh sistem BookStore.
    </div>
@endsection
