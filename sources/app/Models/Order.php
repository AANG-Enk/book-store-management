<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_WAITING_SHIPPING = 'waiting_shipping';
    public const STATUS_WAITING_PAYMENT = 'waiting_payment';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_province',
        'shipping_city',
        'shipping_postal_code',
        'subtotal_price',
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'tracking_number',
        'shipping_confirmed_at',
        'shipped_at',
        'total_price',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_price' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total_price' => 'decimal:2',
            'shipping_confirmed_at' => 'datetime',
            'shipped_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedSubtotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->subtotal_price, 0, ',', '.');
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->shipping_cost, 0, ',', '.');
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }

    public function getShippingAreaAttribute(): string
    {
        return collect([
            $this->shipping_city,
            $this->shipping_province,
            $this->shipping_postal_code,
        ])->filter()->implode(', ') ?: '-';
    }

    public function getShippingCourierLabelAttribute(): string
    {
        return collect([
            $this->shipping_courier,
            $this->shipping_service,
        ])->filter()->implode(' - ') ?: '-';
    }

    public function getIsShippingConfirmedAttribute(): bool
    {
        return $this->shipping_confirmed_at !== null;
    }


    public function getShipmentTimelineAttribute(): array
    {
        return [
            [
                'label' => 'Pesanan dibuat',
                'description' => $this->created_at?->format('d M Y H:i'),
                'active' => true,
            ],
            [
                'label' => 'Ongkir dikonfirmasi',
                'description' => $this->shipping_confirmed_at?->format('d M Y H:i') ?? 'Menunggu admin',
                'active' => $this->shipping_confirmed_at !== null,
            ],
            [
                'label' => 'Pembayaran diverifikasi',
                'description' => $this->payment?->verified_at?->format('d M Y H:i') ?? 'Menunggu pembayaran/verifikasi',
                'active' => $this->payment?->status === \App\Models\Payment::STATUS_VERIFIED,
            ],
            [
                'label' => 'Pesanan dikirim',
                'description' => $this->shipped_at?->format('d M Y H:i') ?? 'Belum dikirim',
                'active' => $this->status === self::STATUS_SHIPPED || $this->status === self::STATUS_COMPLETED || $this->shipped_at !== null,
            ],
            [
                'label' => 'Pesanan selesai',
                'description' => $this->status === self::STATUS_COMPLETED ? 'Selesai' : 'Belum selesai',
                'active' => $this->status === self::STATUS_COMPLETED,
            ],
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Checkout',
            self::STATUS_WAITING_SHIPPING => 'Menunggu Ongkir',
            self::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Sudah Dibayar',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_SHIPPED => 'Dikirim',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'text-bg-warning',
            self::STATUS_WAITING_SHIPPING => 'text-bg-warning',
            self::STATUS_WAITING_PAYMENT => 'text-bg-info',
            self::STATUS_PAID => 'text-bg-primary',
            self::STATUS_PROCESSING => 'text-bg-secondary',
            self::STATUS_SHIPPED => 'text-bg-dark',
            self::STATUS_COMPLETED => 'text-bg-success',
            self::STATUS_CANCELLED => 'text-bg-danger',
            default => 'text-bg-secondary',
        };
    }
}
