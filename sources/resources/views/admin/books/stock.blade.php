@extends('layouts.admin')

@section('title', 'Update Stok Buku - BookStore')
@section('page_title', 'Update Stok Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Update Stok Buku</h1>
            <p class="text-secondary mb-0">
                Perbarui stok untuk buku tertentu tanpa mengubah data lain.
            </p>
        </div>

        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
            Kembali ke Data Buku
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex gap-3">
                        <div class="book-cover-thumb bg-light border d-flex align-items-center justify-content-center">
                            @if ($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}">
                            @else
                                <i class="bi bi-book text-secondary"></i>
                            @endif
                        </div>

                        <div>
                            <h2 class="h5 fw-bold mb-1">{{ $book->title }}</h2>
                            <div class="text-secondary small">
                                {{ $book->category?->name ?? '-' }}
                            </div>
                            <div class="text-secondary small">
                                Supplier: {{ $book->supplier?->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Harga</dt>
                        <dd class="col-sm-7">{{ $book->formatted_price }}</dd>

                        <dt class="col-sm-5">Stok Saat Ini</dt>
                        <dd class="col-sm-7">
                            @if ($book->stock <= 0)
                                <span class="badge text-bg-danger">Habis</span>
                            @elseif ($book->stock <= 5)
                                <span class="badge text-bg-warning">{{ $book->stock }}</span>
                            @else
                                <span class="badge text-bg-success">{{ $book->stock }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Status Buku</dt>
                        <dd class="col-sm-7">
                            @if ($book->is_active)
                                <span class="badge text-bg-success">Aktif</span>
                            @else
                                <span class="badge text-bg-secondary">Nonaktif</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Form Update Stok</h2>

                    <form method="POST" action="{{ route('admin.books.stock.update', $book) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok Baru</label>
                            <input
                                id="stock"
                                type="number"
                                name="stock"
                                class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $book->stock) }}"
                                required
                                min="0"
                            >

                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Masukkan angka stok terbaru. Minimal 0.
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Simpan Stok
                            </button>

                            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <div class="fw-semibold mb-1">Catatan stok</div>
                <div class="small">
                    Stok otomatis berkurang saat customer berhasil checkout.
                    Halaman ini dipakai untuk koreksi manual atau penambahan stok dari supplier.
                </div>
            </div>
        </div>
    </div>
@endsection
