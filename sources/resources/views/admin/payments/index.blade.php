@extends('layouts.admin')

@section('title', 'Pembayaran - BookStore')
@section('page_title', 'Pembayaran')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Pembayaran</h1>
            <p class="text-secondary mb-0">
                Verifikasi bukti transfer yang diupload customer.
            </p>
        </div>
    </div>

    <div class="card content-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Invoice, nama customer, email, bank, pengirim"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua Status</option>
                        <option value="pending" @selected($status === 'pending')>Menunggu Verifikasi</option>
                        <option value="verified" @selected($status === 'verified')>Diverifikasi</option>
                        <option value="rejected" @selected($status === 'rejected')>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card content-card">
        <div class="card-body">
            @if ($payments->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3 mx-auto">
                        <i class="bi bi-credit-card"></i>
                    </div>

                    <h2 class="h5 fw-bold">Belum ada pembayaran</h2>
                    <p class="text-secondary mb-0">
                        Bukti pembayaran customer akan tampil di sini.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Pengirim</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $payment->order->invoice_number }}</div>
                                        <div class="small text-secondary">
                                            {{ $payment->created_at->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $payment->order->customer_name }}</div>
                                        <div class="small text-secondary">{{ $payment->order->customer_email }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $payment->sender_name }}</div>
                                        <div class="small text-secondary">{{ $payment->bank_name ?: '-' }}</div>
                                    </td>
                                    <td class="fw-semibold">
                                        {{ $payment->formatted_transfer_amount }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $payment->status_badge_class }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a
                                            href="{{ route('admin.payments.show', $payment) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
