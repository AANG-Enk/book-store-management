@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak - BookStore')
@section('page_title', 'Detail Pesan Kontak')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pesan Kontak</h1>
            <p class="text-secondary mb-0">
                Pesan dari {{ $contactMessage->name }}.
            </p>
        </div>

        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between gap-3 mb-4">
                        <div>
                            <h2 class="h4 fw-bold mb-1">{{ $contactMessage->subject }}</h2>
                            <div class="text-secondary">
                                Dikirim pada {{ $contactMessage->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div>
                            @if ($contactMessage->is_read)
                                <span class="badge text-bg-success">Sudah Dibaca</span>
                            @else
                                <span class="badge text-bg-warning">Belum Dibaca</span>
                            @endif
                        </div>
                    </div>

                    <div class="border rounded-3 p-4 bg-light">
                        <div style="white-space: pre-line;">{{ $contactMessage->message }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Data Pengirim</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $contactMessage->name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $contactMessage->email }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">{{ $contactMessage->phone ?: '-' }}</dd>

                        <dt class="col-sm-4">Dibaca</dt>
                        <dd class="col-sm-8">
                            {{ $contactMessage->read_at ? $contactMessage->read_at->format('d M Y H:i') : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Aksi</h2>

                    <a
                        href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}"
                        class="btn btn-primary w-100 mb-2"
                    >
                        <i class="bi bi-reply me-1"></i>
                        Balas via Email
                    </a>

                    <form
                        method="POST"
                        action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                        onsubmit="return confirm('Hapus pesan kontak ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger w-100">
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
