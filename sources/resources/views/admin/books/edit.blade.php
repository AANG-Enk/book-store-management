@extends('layouts.admin')

@section('title', 'Edit Buku - BookStore')
@section('page_title', 'Edit Buku')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit Buku</h1>
        <p class="text-secondary mb-0">
            Perbarui informasi buku, stok, harga, dan cover.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @method('PUT')

                @include('admin.books._form', ['book' => $book])
            </form>
        </div>
    </div>
@endsection
