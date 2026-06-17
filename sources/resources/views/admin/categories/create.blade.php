@extends('layouts.admin')

@section('title', 'Tambah Kategori - BookStore')
@section('page_title', 'Tambah Kategori')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Tambah Kategori</h1>
        <p class="text-secondary mb-0">
            Tambahkan kategori baru untuk data buku.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @include('admin.categories._form')
            </form>
        </div>
    </div>
@endsection
