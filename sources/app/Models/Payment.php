<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_REJECTED = 'rejected';

    public const METHOD_MIDTRANS = 'midtrans';
    public const METHOD_BANK_TRANSFER = 'bank_transfer';

    protected $fillable = [
        'order_id',
        'payment_method',
        'bank_name',
        'sender_name',
        'transfer_amount',
        'proof_image',
        'snap_token',
        'transaction_id',
        'payment_type',
        'transaction_status',
        'transaction_time',
        'payment_payload',
        'status',
        'admin_note',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'transfer_amount' => 'decimal:2',
            'verified_at' => 'datetime',
            'transaction_time' => 'datetime',
            'payment_payload' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getIsMidtransAttribute(): bool
    {
        return $this->payment_method === self::METHOD_MIDTRANS || ! empty($this->snap_token);
    }

    public function getProofUrlAttribute(): ?string
    {
        if (! $this->proof_image) {
            return null;
        }

        return asset('storage/'.$this->proof_image);
    }

    public function getFormattedTransferAmountAttribute(): string
    {
        $amount = (float) ($this->transfer_amount ?? $this->order?->total_price ?? 0);

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        if ($this->is_midtrans) {
            $type = $this->payment_type ? strtoupper(str_replace('_', ' ', $this->payment_type)) : 'Payment Gateway';

            return 'Midtrans (' . $type . ')';
        }

        return 'Transfer Bank Manual';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_VERIFIED => 'Pembayaran Berhasil',
            self::STATUS_REJECTED => 'Pembayaran Gagal / Ditolak',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'text-bg-warning',
            self::STATUS_VERIFIED => 'text-bg-success',
            self::STATUS_REJECTED => 'text-bg-danger',
            default => 'text-bg-secondary',
        };
    }
}
