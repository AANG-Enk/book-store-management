@extends('admin.reports.pdf._layout', ['title' => 'Laporan Customer'])

@section('content')
    <div class="header">
        <div class="brand">BookStore</div>
        <h1>Laporan Customer</h1>
        <p class="muted">
            Dicetak pada {{ now()->format('d/m/Y H:i') }}
            @if ($search)
                | Pencarian: {{ $search }}
            @endif
        </p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Customer</div>
                <div class="value">{{ $totalCustomers }}</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>Bergabung</th>
                <th class="text-center">Jumlah Order</th>
                <th class="text-right">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $customer->orders_count }}</td>
                    <td class="text-right">
                        Rp {{ number_format((float) ($customer->orders_sum_total_price ?? 0), 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan dibuat otomatis oleh sistem BookStore.
    </div>
@endsection
