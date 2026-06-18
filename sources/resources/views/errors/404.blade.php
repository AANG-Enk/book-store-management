@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan - BookStore')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm mx-auto" style="max-width: 620px;">
                <div class="card-body text-center p-5">
                    <div class="display-1 fw-bold text-primary">404</div>
                    <h1 class="h3 fw-bold mb-3">Halaman Tidak Ditemukan</h1>
                    <p class="text-secondary mb-4">
                        Halaman yang kamu cari tidak tersedia atau sudah dipindahkan.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary">
                        Ke Beranda
                    </a>

                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                        Lihat Katalog
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
