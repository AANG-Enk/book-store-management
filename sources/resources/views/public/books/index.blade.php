@extends('layouts.public')

@section('title', 'Katalog Buku - BookStore')

@section('content')
    <section class="py-5 bg-white border-bottom">
        <div class="container">
            <div class="row align-items-end g-4">
                <div class="col-lg-7">
                    <span class="badge text-bg-primary mb-3">Katalog Buku</span>
                    <h1 class="display-6 fw-bold mb-3">
                        Temukan Buku yang Kamu Butuhkan
                    </h1>
                    <p class="lead text-secondary mb-0">
                        Jelajahi koleksi buku berdasarkan kategori, penulis, penerbit, atau ISBN.
                    </p>
                </div>

                <div class="col-lg-5">
                    <form method="GET" action="{{ route('books.index') }}" class="card border-0 shadow-sm">
                        <div class="card-body">
                            <label for="search" class="form-label">Cari Buku</label>
                            <div class="input-group">
                                <input
                                    id="search"
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    value="{{ $search }}"
                                    placeholder="Judul, penulis, penerbit, ISBN"
                                >

                                @if ($categorySlug)
                                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                                @endif

                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="card border-0 shadow-sm sticky-lg-top catalog-filter-card">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-3">Kategori</h2>

                            <div class="list-group list-group-flush">
                                <a
                                    href="{{ route('books.index', ['search' => $search ?: null]) }}"
                                    class="list-group-item list-group-item-action px-0 {{ $categorySlug === '' ? 'fw-semibold text-primary' : '' }}"
                                >
                                    Semua Kategori
                                </a>

                                @foreach ($categories as $category)
                                    <a
                                        href="{{ route('books.index', [
                                            'category' => $category->slug,
                                            'search' => $search ?: null,
                                        ]) }}"
                                        class="list-group-item list-group-item-action px-0 {{ $categorySlug === $category->slug ? 'fw-semibold text-primary' : '' }}"
                                    >
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>

                            @if ($search || $categorySlug)
                                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-3">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </div>
                </aside>

                <div class="col-lg-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center mb-4">
                        <div>
                            <h2 class="h4 fw-bold mb-1">
                                @if ($selectedCategory)
                                    Kategori {{ $selectedCategory->name }}
                                @else
                                    Semua Buku
                                @endif
                            </h2>

                            <p class="text-secondary mb-0">
                                Menampilkan {{ $books->total() }} buku tersedia.
                            </p>
                        </div>
                    </div>

                    @if ($books->isEmpty())
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="display-5 text-secondary mb-3">
                                    <i class="bi bi-search"></i>
                                </div>
                                <h3 class="h5 fw-bold">Buku tidak ditemukan</h3>
                                <p class="text-secondary mb-4">
                                    Coba gunakan kata kunci atau kategori lain.
                                </p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">
                                    Lihat Semua Buku
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($books as $book)
                                <div class="col-sm-6 col-xl-4">
                                    <div class="card h-100 border-0 shadow-sm book-card">
                                        <a href="{{ route('books.show', $book) }}" class="book-card-cover bg-light">
                                            @if ($book->cover_url)
                                                <img
                                                    src="{{ $book->cover_url }}"
                                                    alt="Cover {{ $book->title }}"
                                                >
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center text-secondary">
                                                    <i class="bi bi-book display-5"></i>
                                                </div>
                                            @endif
                                        </a>

                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2">
                                                <span class="badge text-bg-light border">
                                                    {{ $book->category?->name ?? '-' }}
                                                </span>
                                            </div>

                                            <h3 class="h6 fw-bold mb-1">
                                                <a href="{{ route('books.show', $book) }}" class="text-dark">
                                                    {{ $book->title }}
                                                </a>
                                            </h3>

                                            <p class="small text-secondary mb-2">
                                                {{ $book->author ?: 'Penulis belum diisi' }}
                                            </p>

                                            <div class="mt-auto">
                                                <div class="fw-bold text-primary mb-2">
                                                    {{ $book->formatted_price }}
                                                </div>

                                                @if ($book->stock > 0)
                                                    <div class="small text-success mb-3">
                                                        Stok tersedia: {{ $book->stock }}
                                                    </div>
                                                @else
                                                    <div class="small text-danger mb-3">
                                                        Stok habis
                                                    </div>
                                                @endif

                                                <div class="d-grid gap-2">
                                                <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm">
                                                    Lihat Detail
                                                </a>

                                                @auth
                                                    @if (auth()->user()->isCustomer())
                                                        @if ($book->stock > 0)
                                                            <form method="POST" action="{{ route('customer.cart.store', $book) }}">
                                                                @csrf

                                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                                    <i class="bi bi-cart-plus me-1"></i>
                                                                    Keranjang
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="btn btn-secondary btn-sm w-100" disabled>
                                                                Stok Habis
                                                            </button>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                                        Login untuk Beli
                                                    </a>
                                                @endauth
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
