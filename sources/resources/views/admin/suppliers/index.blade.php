@extends('layouts.admin')

@section('title', 'Supplier - BookStore')
@section('page_title', 'Supplier')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Supplier</h1>
            <p class="text-secondary mb-0">
                Kelola data pemasok buku untuk kebutuhan stok toko.
            </p>
        </div>

        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Supplier
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.suppliers.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Nama, telepon, email, alamat"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua Status</option>
                        <option value="active" @selected($status === 'active')>Aktif</option>
                        <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($suppliers->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-truck"></i>
                    </div>

                    <h2 class="h5 fw-bold">Belum ada supplier</h2>
                    <p class="text-secondary mb-4">
                        Tambahkan supplier untuk melengkapi data pemasok buku.
                    </p>

                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                        Tambah Supplier
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Supplier</th>
                                <th>Kontak</th>
                                <th>Jumlah Buku</th>
                                <th>Status</th>
                                <th class="text-end" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $suppliers->firstItem() + $loop->index }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $supplier->name }}</div>

                                        @if ($supplier->address)
                                            <div class="small text-secondary">
                                                {{ \Illuminate\Support\Str::limit($supplier->address, 80) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div>{{ $supplier->phone ?: '-' }}</div>
                                        <div class="small text-secondary">
                                            {{ $supplier->email ?: '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge text-bg-light border">
                                            {{ $supplier->books_count }} buku
                                        </span>
                                    </td>

                                    <td>
                                        @if ($supplier->is_active)
                                            <span class="badge text-bg-success">Aktif</span>
                                        @else
                                            <span class="badge text-bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <a
                                                href="{{ route('admin.suppliers.edit', $supplier) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
