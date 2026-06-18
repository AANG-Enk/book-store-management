@extends('admin.reports.pdf._layout', ['title' => 'Laporan Stok Buku'])

@section('content')
    <div class="header">
        <div class="brand">BookStore</div>
        <h1>Laporan Stok Buku</h1>
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
                <div class="label">Total Buku</div>
                <div class="value">{{ $totalBooks }}</div>
            </td>
            <td>
                <div class="label">Stok Habis</div>
                <div class="value">{{ $emptyStock }}</div>
            </td>
            <td>
                <div class="label">Stok Menipis</div>
                <div class="value">{{ $lowStock }}</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                @php
                    $stockLabel = 'Aman';

                    if ($book->stock <= 0) {
                        $stockLabel = 'Habis';
                    } elseif ($book->stock <= 5) {
                        $stockLabel = 'Menipis';
                    }
                @endphp

                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author ?: '-' }}</td>
                    <td>{{ $book->category?->name ?? '-' }}</td>
                    <td>{{ $book->supplier?->name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format((float) $book->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $book->stock }}</td>
                    <td>{{ $stockLabel }}</td>
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
