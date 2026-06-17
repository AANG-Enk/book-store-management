@extends('layouts.admin')

@section('title', 'Tambah Supplier - BookStore')
@section('page_title', 'Tambah Supplier')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Tambah Supplier</h1>
        <p class="text-secondary mb-0">
            Tambahkan data pemasok buku baru.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.suppliers.store') }}">
                @include('admin.suppliers._form')
            </form>
        </div>
    </div>
@endsection
