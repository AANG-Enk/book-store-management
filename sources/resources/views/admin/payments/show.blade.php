@extends('layouts.admin')

@section('title', 'Detail Pembayaran - BookStore')
@section('page_title', 'Detail Pembayaran')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pembayaran</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold">{{ $payment->order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Bukti Transfer</h2>

                    <a href="{{ $payment->proof_url }}" target="_blank">
                        <img
                            src="{{ $payment->proof_url }}"
                            alt="Bukti pembayaran"
                            class="payment-proof-admin border"
                        >
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Item Pesanan</h2>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->order->items as $item)
                                    <tr>
                                        <td>{{ $item->book_title }}</td>
                                        <td>{{ $item->formatted_book_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total Order</th>
                                    <th class="text-end text-primary">
                                        {{ $payment->order->formatted_total_price }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Nominal Transfer</th>
                                    <th class="text-end text-primary">
                                        {{ $payment->formatted_transfer_amount }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Informasi Pembayaran</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">
                            <span class="badge {{ $payment->status_badge_class }}">
                                {{ $payment->status_label }}
                            </span>
                        </dd>

                        <dt class="col-sm-5">Bank / Metode</dt>
                        <dd class="col-sm-7">{{ $payment->bank_name ?: '-' }}</dd>

                        <dt class="col-sm-5">Nama Pengirim</dt>
                        <dd class="col-sm-7">{{ $payment->sender_name }}</dd>

                        <dt class="col-sm-5">Nominal</dt>
                        <dd class="col-sm-7 fw-semibold">{{ $payment->formatted_transfer_amount }}</dd>

                        <dt class="col-sm-5">Upload</dt>
                        <dd class="col-sm-7">{{ $payment->created_at->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-5">Diverifikasi</dt>
                        <dd class="col-sm-7">
                            {{ $payment->verified_at ? $payment->verified_at->format('d M Y H:i') : '-' }}
                        </dd>

                        <dt class="col-sm-5">Catatan Admin</dt>
                        <dd class="col-sm-7" style="white-space: pre-line;">{{ $payment->admin_note ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            @if ($payment->status !== \App\Models\Payment::STATUS_VERIFIED)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Verifikasi</h2>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.verify', $payment) }}"
                            onsubmit="return confirm('Verifikasi pembayaran ini?')"
                            class="mb-3"
                        >
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i>
                                Verifikasi Pembayaran
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.reject', $payment) }}"
                            onsubmit="return confirm('Tolak pembayaran ini?')"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="admin_note" class="form-label">Alasan Penolakan</label>
                                <textarea
                                    id="admin_note"
                                    name="admin_note"
                                    rows="4"
                                    class="form-control @error('admin_note') is-invalid @enderror"
                                    required
                                    maxlength="1000"
                                    placeholder="Contoh: Nominal transfer tidak sesuai / bukti tidak jelas"
                                >{{ old('admin_note') }}</textarea>

                                @error('admin_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-1"></i>
                                Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Customer</h2>

                    <div class="fw-semibold">{{ $payment->order->customer_name }}</div>
                    <div class="text-secondary">{{ $payment->order->customer_email }}</div>
                    <div class="text-secondary">{{ $payment->order->customer_phone ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
