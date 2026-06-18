@extends('layouts.public')

@section('title', 'Kontak - BookStore')

@section('content')
    <section class="py-5 bg-white border-bottom">
        <div class="container">
            <div class="row align-items-end g-4">
                <div class="col-lg-8">
                    <span class="badge text-bg-primary mb-3">Kontak</span>
                    <h1 class="display-6 fw-bold mb-3">
                        Hubungi BookStore
                    </h1>
                    <p class="lead text-secondary mb-0">
                        Kirim pesan, pertanyaan, atau masukan melalui form kontak berikut.
                    </p>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex gap-3 align-items-start mb-3">
                                <i class="bi bi-envelope text-primary fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <div class="text-secondary">info@bookstore.test</div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 align-items-start">
                                <i class="bi bi-telephone text-primary fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Telepon</div>
                                    <div class="text-secondary">0812-3456-7890</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </section>

    <section class="py-5">
        <div class="container">
            @include('partials.flash')

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold mb-3">Form Kontak</h2>

                            <form method="POST" action="{{ route('contact.submit') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nama</label>
                                        <input
                                            id="name"
                                            type="text"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}"
                                            required
                                            maxlength="150"
                                        >

                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input
                                            id="email"
                                            type="email"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}"
                                            required
                                            maxlength="150"
                                        >

                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">No. Telepon</label>
                                        <input
                                            id="phone"
                                            type="text"
                                            name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}"
                                            maxlength="30"
                                            placeholder="Opsional"
                                        >

                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Subjek</label>
                                        <input
                                            id="subject"
                                            type="text"
                                            name="subject"
                                            class="form-control @error('subject') is-invalid @enderror"
                                            value="{{ old('subject') }}"
                                            required
                                            maxlength="200"
                                        >

                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="message" class="form-label">Pesan</label>
                                        <textarea
                                            id="message"
                                            name="message"
                                            rows="6"
                                            class="form-control @error('message') is-invalid @enderror"
                                            required
                                            maxlength="3000"
                                        >{{ old('message') }}</textarea>

                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">
                                    <i class="bi bi-send me-1"></i>
                                    Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4 p-lg-5">
                            <h2 class="h4 fw-bold mb-3">Informasi</h2>

                            <p class="text-secondary">
                                Pesan yang dikirim dari form ini akan masuk ke dashboard admin.
                                Admin dapat membaca dan menandai pesan sebagai sudah dibaca.
                            </p>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 bg-transparent">
                                    <div class="fw-semibold">Jam Operasional</div>
                                    <div class="text-secondary small">Senin - Sabtu, 08.00 - 17.00</div>
                                </div>

                                <div class="list-group-item px-0 bg-transparent">
                                    <div class="fw-semibold">Alamat</div>
                                    <div class="text-secondary small">Jl. Pendidikan No. 10, Bandung</div>
                                </div>

                                <div class="list-group-item px-0 bg-transparent">
                                    <div class="fw-semibold">Respon Pesan</div>
                                    <div class="text-secondary small">Pesan akan diperiksa oleh admin toko.</div>
                                </div>
                            </div>

                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary w-100 mt-4">
                                Lihat Katalog Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
