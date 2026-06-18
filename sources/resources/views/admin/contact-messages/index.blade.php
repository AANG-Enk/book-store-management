@extends('layouts.admin')

@section('title', 'Pesan Kontak - BookStore')
@section('page_title', 'Pesan Kontak')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Pesan Kontak</h1>
            <p class="text-secondary mb-0">
                Kelola pesan yang dikirim pengunjung melalui halaman kontak.
            </p>
        </div>
    </div>

    <div class="card content-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Nama, email, telepon, subjek, pesan"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua Status</option>
                        <option value="unread" @selected($status === 'unread')>Belum Dibaca</option>
                        <option value="read" @selected($status === 'read')>Sudah Dibaca</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card content-card">
        <div class="card-body">
            @if ($messages->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3 mx-auto">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <h2 class="h5 fw-bold">Belum ada pesan kontak</h2>
                    <p class="text-secondary mb-0">
                        Pesan dari halaman kontak akan tampil di sini.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($messages as $message)
                                <tr class="{{ $message->is_read ? '' : 'table-warning' }}">
                                    <td>
                                        <div class="fw-semibold">{{ $message->name }}</div>
                                        <div class="small text-secondary">{{ $message->email }}</div>
                                        <div class="small text-secondary">{{ $message->phone ?: '-' }}</div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $message->subject }}</div>
                                        <div class="small text-secondary">
                                            {{ \Illuminate\Support\Str::limit($message->message, 90) }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $message->created_at->format('d M Y H:i') }}
                                    </td>

                                    <td>
                                        @if ($message->is_read)
                                            <span class="badge text-bg-success">Sudah Dibaca</span>
                                        @else
                                            <span class="badge text-bg-warning">Belum Dibaca</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <a
                                                href="{{ route('admin.contact-messages.show', $message) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Detail
                                            </a>

                                            @if (! $message->is_read)
                                                <form method="POST" action="{{ route('admin.contact-messages.read', $message) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                                        Dibaca
                                                    </button>
                                                </form>
                                            @endif

                                            <form
                                                method="POST"
                                                action="{{ route('admin.contact-messages.destroy', $message) }}"
                                                onsubmit="return confirm('Hapus pesan kontak ini?')"
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
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
