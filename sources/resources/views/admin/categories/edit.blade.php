@extends('layouts.admin')

@section('title', 'Edit Kategori - BookStore')
@section('page_title', 'Edit Kategori')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit Kategori</h1>
        <p class="text-secondary mb-0">
            Perbarui informasi kategori buku.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @method('PUT')

                @include('admin.categories._form', ['category' => $category])
            </form>
        </div>
    </div>
@endsection
