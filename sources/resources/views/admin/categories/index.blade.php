@extends('layouts.admin')

@section('title', 'Kategori Buku - BookStore')
@section('page_title', 'Kategori Buku')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Kategori Buku</h1>
            <p class="text-secondary mb-0">
                Kelola kategori untuk mengelompokkan data buku.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kategori
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Cari nama atau deskripsi kategori"
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

                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($categories->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h2 class="h5 fw-bold">Belum ada kategori</h2>
                    <p class="text-secondary mb-4">
                        Tambahkan kategori pertama untuk mulai mengelompokkan buku.
                    </p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        Tambah Kategori
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th class="text-end" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        {{ $categories->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        @if ($category->description)
                                            <div class="small text-secondary">
                                                {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge text-bg-success">Aktif</span>
                                        @else
                                            <span class="badge text-bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small text-secondary">
                                            {{ $category->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.categories.destroy', $category) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
