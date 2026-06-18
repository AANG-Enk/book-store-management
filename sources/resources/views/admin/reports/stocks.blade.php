@extends('layouts.admin')

@section('title', 'Laporan Stok Buku - BookStore')
@section('page_title', 'Laporan Stok Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Laporan Stok Buku</h1>
            <p class="text-secondary mb-0">
                Pantau stok buku yang aman, menipis, atau habis.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a
                href="{{ route('admin.reports.stocks.export', request()->query()) }}"
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
            <form method="GET" action="{{ route('admin.reports.stocks') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari Buku</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Judul, penulis, ISBN"
                    >
                </div>

                <div class="col-md-3">
                    <label for="stock_status" class="form-label">Status Stok</label>
                    <select id="stock_status" name="stock_status" class="form-select">
                        <option value="" @selected($stockStatus === '')>Semua Stok</option>
                        <option value="empty" @selected($stockStatus === 'empty')>Habis</option>
                        <option value="low" @selected($stockStatus === 'low')>Menipis</option>
                        <option value="safe" @selected($stockStatus === 'safe')>Aman</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.reports.stocks') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Buku</p>
                    <h2 class="h4 fw-bold mb-0">{{ $totalBooks }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Stok Habis</p>
                    <h2 class="h4 fw-bold mb-0">{{ $emptyStock }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Stok Menipis</p>
                    <h2 class="h4 fw-bold mb-0">{{ $lowStock }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($books->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h2 class="h5 fw-bold">Data stok tidak ditemukan</h2>
                    <p class="text-secondary mb-0">
                        Coba ubah filter pencarian atau status stok.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $book->title }}</div>
                                        <div class="small text-secondary">
                                            {{ $book->author ?: 'Penulis belum diisi' }}
                                        </div>
                                    </td>
                                    <td>{{ $book->category?->name ?? '-' }}</td>
                                    <td>{{ $book->supplier?->name ?? '-' }}</td>
                                    <td>{{ $book->formatted_price }}</td>
                                    <td>
                                        @if ($book->stock <= 0)
                                            <span class="badge text-bg-danger">Habis</span>
                                        @elseif ($book->stock <= 5)
                                            <span class="badge text-bg-warning">{{ $book->stock }}</span>
                                        @else
                                            <span class="badge text-bg-success">{{ $book->stock }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($book->is_active)
                                            <span class="badge text-bg-success">Aktif</span>
                                        @else
                                            <span class="badge text-bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a
                                            href="{{ route('admin.books.stock.edit', $book) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Update Stok
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
