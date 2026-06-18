@extends('layouts.public')

@section('title', 'Katalog Buku - BookStore')

@section('content')
    <section class="py-5 soft-panel border-bottom">
        <div class="container">
            <div class="row align-items-center g-4 py-lg-4">
                <div class="col-lg-7">
                    <span class="section-kicker mb-3">
                        <i class="bi bi-book"></i>
                        Katalog Buku
                    </span>

                    <h1 class="display-6 fw-bold hero-title mb-3">
                        Cari Buku dengan Tampilan yang Lebih Nyaman Dibaca
                    </h1>

                    <p class="lead text-secondary mb-0">
                        Temukan buku berdasarkan judul, penulis, penerbit, ISBN, atau kategori. Desain dibuat sederhana agar nyaman untuk pengguna muda maupun tua.
                    </p>
                </div>

                <div class="col-lg-5">
                    <form method="GET" action="{{ route('books.index') }}" class="card content-card">
                        <div class="card-body p-4">
                            <label for="search" class="form-label fw-semibold">Cari Buku</label>
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
                                    <i class="bi bi-search me-1"></i>
                                    Cari
                                </button>
                            </div>

                            @if ($search || $categorySlug)
                                <a href="{{ route('books.index') }}" class="small d-inline-flex mt-3">
                                    Reset semua filter
                                </a>
                            @endif
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
                    <div class="card content-card sticky-lg-top catalog-filter-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="h5 fw-bold mb-0">Kategori</h2>
                                <span class="badge text-bg-light border">{{ $categories->count() }}</span>
                            </div>

                            <div class="d-grid gap-1">
                                <a
                                    href="{{ route('books.index', ['search' => $search ?: null]) }}"
                                    class="catalog-category-pill {{ $categorySlug === '' ? 'active' : '' }}"
                                >
                                    <span>Semua Kategori</span>
                                    <i class="bi bi-chevron-right small"></i>
                                </a>

                                @foreach ($categories as $category)
                                    <a
                                        href="{{ route('books.index', [
                                            'category' => $category->slug,
                                            'search' => $search ?: null,
                                        ]) }}"
                                        class="catalog-category-pill {{ $categorySlug === $category->slug ? 'active' : '' }}"
                                    >
                                        <span>{{ $category->name }}</span>
                                        <i class="bi bi-chevron-right small"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="col-lg-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
                        <div>
                            <h2 class="h3 fw-bold mb-1">
                                @if ($selectedCategory)
                                    {{ $selectedCategory->name }}
                                @else
                                    Semua Buku
                                @endif
                            </h2>

                            <p class="text-secondary mb-0">
                                Menampilkan {{ $books->total() }} buku tersedia.
                            </p>
                        </div>

                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-question-circle me-1"></i>
                            Butuh bantuan?
                        </a>
                    </div>

                    @if ($books->isEmpty())
                        <div class="card content-card">
                            <div class="card-body text-center py-5">
                                <div class="empty-state-icon mb-3 mx-auto">
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
                                    <article class="card h-100 content-card book-card">
                                        <a href="{{ route('books.show', $book) }}" class="book-card-cover" aria-label="Lihat detail {{ $book->title }}">
                                            @if ($book->cover_url)
                                                <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center text-secondary brand-soft-primary">
                                                    <i class="bi bi-book display-5"></i>
                                                </div>
                                            @endif
                                        </a>

                                        <div class="card-body d-flex flex-column p-4">
                                            <div class="d-flex justify-content-between gap-2 align-items-start mb-3">
                                                <span class="badge text-bg-light border">
                                                    {{ $book->category?->name ?? '-' }}
                                                </span>

                                                @if ($book->stock > 0)
                                                    <span class="badge text-bg-success">Stok {{ $book->stock }}</span>
                                                @else
                                                    <span class="badge text-bg-danger">Habis</span>
                                                @endif
                                            </div>

                                            <h3 class="h6 fw-bold mb-1">
                                                <a href="{{ route('books.show', $book) }}" class="text-dark">
                                                    {{ $book->title }}
                                                </a>
                                            </h3>

                                            <p class="small text-secondary mb-3">
                                                {{ $book->author ?: 'Penulis belum diisi' }}
                                            </p>

                                            <div class="mt-auto">
                                                <div class="book-price h5 mb-3">
                                                    {{ $book->formatted_price }}
                                                </div>

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
                                                                        Tambah Keranjang
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
                                    </article>
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
