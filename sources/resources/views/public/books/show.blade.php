@extends('layouts.public')

@section('title', $book->title . ' - BookStore')

@section('content')
    <section class="py-5 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('books.index') }}">Katalog</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $book->title }}
                    </li>
                </ol>
            </nav>

            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="book-detail-cover bg-light border shadow-sm">
                        @if ($book->cover_url)
                            <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-secondary">
                                <i class="bi bi-book display-1"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-7">
                    <span class="badge text-bg-light border mb-3">
                        {{ $book->category?->name ?? '-' }}
                    </span>

                    <h1 class="display-6 fw-bold mb-3">
                        {{ $book->title }}
                    </h1>

                    <div class="d-flex flex-wrap gap-3 text-secondary mb-4">
                        @if ($book->author)
                            <div>
                                <i class="bi bi-person me-1"></i>
                                {{ $book->author }}
                            </div>
                        @endif

                        @if ($book->publisher)
                            <div>
                                <i class="bi bi-building me-1"></i>
                                {{ $book->publisher }}
                            </div>
                        @endif

                        @if ($book->publication_year)
                            <div>
                                <i class="bi bi-calendar me-1"></i>
                                {{ $book->publication_year }}
                            </div>
                        @endif
                    </div>

                    <div class="display-6 fw-bold text-primary mb-3">
                        {{ $book->formatted_price }}
                    </div>

                    @if ($book->stock > 0)
                        <div class="alert alert-success d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-circle"></i>
                            Stok tersedia: {{ $book->stock }}
                        </div>
                    @else
                        <div class="alert alert-danger d-inline-flex align-items-center gap-2">
                            <i class="bi bi-x-circle"></i>
                            Stok habis
                        </div>
                    @endif

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        @auth
                            @if (auth()->user()->isCustomer())
                                <a href="#" class="btn btn-primary disabled">
                                    <i class="bi bi-cart-plus me-1"></i>
                                    Tambah ke Keranjang
                                </a>
                            @else
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit di Admin
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                Login untuk Belanja
                            </a>
                        @endauth

                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                            Kembali ke Katalog
                        </a>
                    </div>

                    <hr class="my-4">

                    <dl class="row mb-0">
                        <dt class="col-sm-4">ISBN</dt>
                        <dd class="col-sm-8">{{ $book->isbn ?: '-' }}</dd>

                        <dt class="col-sm-4">Kategori</dt>
                        <dd class="col-sm-8">{{ $book->category?->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Penerbit</dt>
                        <dd class="col-sm-8">{{ $book->publisher ?: '-' }}</dd>

                        <dt class="col-sm-4">Tahun Terbit</dt>
                        <dd class="col-sm-8">{{ $book->publication_year ?: '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="h4 fw-bold mb-3">Deskripsi Buku</h2>

                    @if ($book->description)
                        <p class="text-secondary mb-0" style="white-space: pre-line;">{{ $book->description }}</p>
                    @else
                        <p class="text-secondary mb-0">
                            Deskripsi buku belum tersedia.
                        </p>
                    @endif
                </div>
            </div>

            @if ($relatedBooks->isNotEmpty())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Buku Terkait</h2>
                        <p class="text-secondary mb-0">
                            Buku lain dari kategori yang sama.
                        </p>
                    </div>

                    <a
                        href="{{ route('books.index', ['category' => $book->category?->slug]) }}"
                        class="btn btn-outline-primary btn-sm"
                    >
                        Lihat Semua
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($relatedBooks as $relatedBook)
                        <div class="col-sm-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm book-card">
                                <a href="{{ route('books.show', $relatedBook) }}" class="book-card-cover bg-light">
                                    @if ($relatedBook->cover_url)
                                        <img
                                            src="{{ $relatedBook->cover_url }}"
                                            alt="Cover {{ $relatedBook->title }}"
                                        >
                                    @else
                                        <div class="h-100 d-flex align-items-center justify-content-center text-secondary">
                                            <i class="bi bi-book display-6"></i>
                                        </div>
                                    @endif
                                </a>

                                <div class="card-body">
                                    <h3 class="h6 fw-bold mb-1">
                                        <a href="{{ route('books.show', $relatedBook) }}" class="text-dark">
                                            {{ $relatedBook->title }}
                                        </a>
                                    </h3>

                                    <p class="small text-secondary mb-2">
                                        {{ $relatedBook->author ?: 'Penulis belum diisi' }}
                                    </p>

                                    <div class="fw-bold text-primary">
                                        {{ $relatedBook->formatted_price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
