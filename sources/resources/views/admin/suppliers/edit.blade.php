@extends('layouts.admin')

@section('title', 'Edit Supplier - BookStore')
@section('page_title', 'Edit Supplier')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Edit Supplier</h1>
        <p class="text-secondary mb-0">
            Perbarui informasi supplier buku.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
                @method('PUT')

                @include('admin.suppliers._form', ['supplier' => $supplier])
            </form>
        </div>
    </div>
@endsection
