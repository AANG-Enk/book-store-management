@extends('layouts.public')

@section('title', $book->title . ' - BookStore')

@section('content')
    <section class="py-5 soft-panel border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Katalog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
                </ol>
            </nav>

            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="book-detail-cover bg-light border">
                        @if ($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-secondary brand-soft-primary">
                                <i class="bi bi-book display-1"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-7">
                    <span class="section-kicker mb-3">
                        <i class="bi bi-tag"></i>
                        {{ $book->category?->name ?? 'Tanpa kategori' }}
                    </span>

                    <h1 class="display-6 fw-bold hero-title mb-3">{{ $book->title }}</h1>

                    <div class="d-flex flex-wrap gap-3 text-secondary mb-4">
                        @if ($book->author)
                            <div><i class="bi bi-person me-1"></i>{{ $book->author }}</div>
                        @endif

                        @if ($book->publisher)
                            <div><i class="bi bi-building me-1"></i>{{ $book->publisher }}</div>
                        @endif

                        @if ($book->publication_year)
                            <div><i class="bi bi-calendar me-1"></i>{{ $book->publication_year }}</div>
                        @endif
                    </div>

                    <div class="card content-card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 align-items-sm-center">
                                <div>
                                    <div class="small text-secondary fw-semibold">Harga Buku</div>
                                    <div class="display-6 book-price">{{ $book->formatted_price }}</div>
                                </div>

                                @if ($book->stock > 0)
                                    <span class="badge text-bg-success align-self-start align-self-sm-center">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Stok {{ $book->stock }}
                                    </span>
                                @else
                                    <span class="badge text-bg-danger align-self-start align-self-sm-center">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Stok Habis
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 d-flex flex-wrap gap-2">
                                @auth
                                    @if (auth()->user()->isCustomer())
                                        @if ($book->stock > 0)
                                            <form method="POST" action="{{ route('customer.cart.store', $book) }}" class="d-flex flex-column flex-sm-row gap-2 align-items-stretch align-items-sm-center">
                                                @csrf

                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    value="1"
                                                    min="1"
                                                    max="{{ $book->stock }}"
                                                    class="form-control"
                                                    style="max-width: 110px;"
                                                    aria-label="Jumlah buku"
                                                >

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-cart-plus me-1"></i>
                                                    Tambah ke Keranjang
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary" disabled>Stok Habis</button>
                                        @endif
                                    @else
                                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary">
                                            <i class="bi bi-pencil me-1"></i>
                                            Edit di Admin
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Belanja</a>
                                @endauth

                                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Kembali ke Katalog</a>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6"><div class="mobile-data-card"><div class="small text-secondary">ISBN</div><div class="fw-semibold">{{ $book->isbn ?: '-' }}</div></div></div>
                        <div class="col-sm-6"><div class="mobile-data-card"><div class="small text-secondary">Kategori</div><div class="fw-semibold">{{ $book->category?->name ?? '-' }}</div></div></div>
                        <div class="col-sm-6"><div class="mobile-data-card"><div class="small text-secondary">Penerbit</div><div class="fw-semibold">{{ $book->publisher ?: '-' }}</div></div></div>
                        <div class="col-sm-6"><div class="mobile-data-card"><div class="small text-secondary">Tahun Terbit</div><div class="fw-semibold">{{ $book->publication_year ?: '-' }}</div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card content-card mb-5">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="h4 fw-bold mb-3">Deskripsi Buku</h2>

                    @if ($book->description)
                        <p class="text-secondary mb-0" style="white-space: pre-line;">{{ $book->description }}</p>
                    @else
                        <p class="text-secondary mb-0">Deskripsi buku belum tersedia.</p>
                    @endif
                </div>
            </div>

            @if ($relatedBooks->isNotEmpty())
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end mb-4">
                    <div>
                        <h2 class="h3 fw-bold mb-1">Buku Terkait</h2>
                        <p class="text-secondary mb-0">Buku lain dari kategori yang sama.</p>
                    </div>

                    <a href="{{ route('books.index', ['category' => $book->category?->slug]) }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($relatedBooks as $relatedBook)
                        <div class="col-sm-6 col-lg-3">
                            <article class="card h-100 content-card book-card">
                                <a href="{{ route('books.show', $relatedBook) }}" class="book-card-cover">
                                    @if ($relatedBook->cover_url)
                                        <img src="{{ $relatedBook->cover_url }}" alt="Cover {{ $relatedBook->title }}">
                                    @else
                                        <div class="h-100 d-flex align-items-center justify-content-center text-secondary brand-soft-primary">
                                            <i class="bi bi-book display-6"></i>
                                        </div>
                                    @endif
                                </a>

                                <div class="card-body p-4">
                                    <h3 class="h6 fw-bold mb-1"><a href="{{ route('books.show', $relatedBook) }}" class="text-dark">{{ $relatedBook->title }}</a></h3>
                                    <p class="small text-secondary mb-2">{{ $relatedBook->author ?: 'Penulis belum diisi' }}</p>
                                    <div class="book-price">{{ $relatedBook->formatted_price }}</div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
