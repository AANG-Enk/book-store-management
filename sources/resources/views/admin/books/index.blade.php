@extends('layouts.admin')

@section('title', 'Data Buku - BookStore')
@section('page_title', 'Data Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Data Buku</h1>
            <p class="text-secondary mb-0">
                Kelola katalog buku, stok, harga, dan informasi buku.
            </p>
        </div>

        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Buku
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.books.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Judul, penulis, penerbit, ISBN"
                    >
                </div>

                <div class="col-md-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua</option>
                        <option value="active" @selected($status === 'active')>Aktif</option>
                        <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($books->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-book"></i>
                    </div>
                    <h2 class="h5 fw-bold">Belum ada buku</h2>
                    <p class="text-secondary mb-4">
                        Tambahkan buku pertama untuk mulai membuat katalog.
                    </p>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        Tambah Buku
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Buku</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $books->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="book-cover-thumb bg-light border d-flex align-items-center justify-content-center">
                                                @if ($book->cover_url)
                                                    <img
                                                        src="{{ $book->cover_url }}"
                                                        alt="Cover {{ $book->title }}"
                                                    >
                                                @else
                                                    <i class="bi bi-book text-secondary"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="fw-semibold">{{ $book->title }}</div>

                                                <div class="small text-secondary">
                                                    @if ($book->author)
                                                        {{ $book->author }}
                                                    @else
                                                        Penulis belum diisi
                                                    @endif
                                                </div>

                                                @if ($book->isbn)
                                                    <div class="small text-secondary">
                                                        ISBN: {{ $book->isbn }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-light border">
                                            {{ $book->category?->name ?? '-' }}
                                        </span>
                                    </td>
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
                                        <div class="d-inline-flex gap-2">
                                            <a
                                                href="{{ route('admin.books.edit', $book) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.books.destroy', $book) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
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
