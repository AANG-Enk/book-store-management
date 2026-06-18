@extends('layouts.customer')

@section('title', 'Upload Pembayaran - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Upload Bukti Pembayaran</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold">{{ $order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-outline-secondary">
            Kembali ke Detail Pesanan
        </a>
    </div>

    @if ($order->payment && $order->payment->status === \App\Models\Payment::STATUS_REJECTED)
        <div class="alert alert-danger">
            <div class="fw-semibold">Pembayaran sebelumnya ditolak.</div>
            <div>{{ $order->payment->admin_note }}</div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card content-card">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Form Pembayaran</h2>

                    <form method="POST" action="{{ route('customer.payments.store', $order) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Bank / Metode Transfer</label>
                            <input
                                id="bank_name"
                                type="text"
                                name="bank_name"
                                class="form-control @error('bank_name') is-invalid @enderror"
                                value="{{ old('bank_name', $order->payment->bank_name ?? '') }}"
                                maxlength="100"
                                placeholder="Contoh: BCA, BRI, Mandiri, Dana"
                            >

                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sender_name" class="form-label">Nama Pengirim</label>
                            <input
                                id="sender_name"
                                type="text"
                                name="sender_name"
                                class="form-control @error('sender_name') is-invalid @enderror"
                                value="{{ old('sender_name', $order->payment->sender_name ?? $order->customer_name) }}"
                                required
                                maxlength="150"
                            >

                            @error('sender_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="transfer_amount" class="form-label">Nominal Transfer</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    id="transfer_amount"
                                    type="number"
                                    name="transfer_amount"
                                    class="form-control @error('transfer_amount') is-invalid @enderror"
                                    value="{{ old('transfer_amount', (int) ($order->payment->transfer_amount ?? $order->total_price)) }}"
                                    required
                                    min="1"
                                    step="100"
                                >

                                @error('transfer_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="proof_image" class="form-label">Bukti Transfer</label>
                            <input
                                id="proof_image"
                                type="file"
                                name="proof_image"
                                class="form-control @error('proof_image') is-invalid @enderror"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                required
                            >

                            @error('proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Format jpg, jpeg, png, webp. Maksimal 2MB.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Ringkasan Pesanan</h2>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Invoice</span>
                        <span class="fw-semibold">{{ $order->invoice_number }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Total Pembayaran</span>
                        <span class="fw-semibold text-primary">{{ $order->formatted_total_price }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Status</span>
                        <span class="badge {{ $order->status_badge_class }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            @if ($order->payment && $order->payment->proof_image)
                <div class="card content-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Bukti Saat Ini</h2>

                        <img
                            src="{{ $order->payment->proof_url }}"
                            alt="Bukti pembayaran"
                            class="payment-proof-preview border"
                        >

                        <div class="mt-3">
                            <span class="badge {{ $order->payment->status_badge_class }}">
                                {{ $order->payment->status_label }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
