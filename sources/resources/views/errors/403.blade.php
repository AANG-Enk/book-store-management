@extends('layouts.public')

@section('title', 'Akses Ditolak - BookStore')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm mx-auto" style="max-width: 620px;">
                <div class="card-body text-center p-5">
                    <div class="display-1 fw-bold text-danger">403</div>
                    <h1 class="h3 fw-bold mb-3">Akses Ditolak</h1>
                    <p class="text-secondary mb-4">
                        Kamu tidak memiliki izin untuk membuka halaman ini.
                    </p>

                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Kembali ke Dashboard
                    </a>

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        Ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
