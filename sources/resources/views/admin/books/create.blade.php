@extends('layouts.admin')

@section('title', 'Tambah Buku - BookStore')
@section('page_title', 'Tambah Buku')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Tambah Buku</h1>
        <p class="text-secondary mb-0">
            Tambahkan data buku baru ke katalog toko.
        </p>
    </div>

    @if ($categories->isEmpty())
        <div class="alert alert-warning">
            <div class="fw-semibold">Kategori belum tersedia.</div>
            <div>
                Tambahkan kategori aktif terlebih dahulu sebelum menambahkan buku.
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-warning btn-sm mt-3">
                Tambah Kategori
            </a>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                    @include('admin.books._form')
                </form>
            </div>
        </div>
    @endif
@endsection
