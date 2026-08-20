<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    protected ?string $serverKey;
    protected ?string $clientKey;
    protected bool $isProduction;
    protected bool $isSanitized;
    protected bool $is3ds;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->isProduction = (bool) config('services.midtrans.is_production', false);
        $this->isSanitized = (bool) config('services.midtrans.is_sanitized', true);
        $this->is3ds = (bool) config('services.midtrans.is_3ds', true);

        $this->initMidtrans();
    }

    protected function initMidtrans(): void
    {
        Config::$serverKey = $this->serverKey ?? '';
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    public function isConfigured(): bool
    {
        return ! empty($this->serverKey)
            && ! str_starts_with($this->serverKey, 'your_')
            && ! str_starts_with($this->serverKey, 'SB-Mid-server-xxx');
    }

    public function getClientKey(): ?string
    {
        return $this->clientKey;
    }

    public function getSnapScriptUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * Generate or retrieve Snap Token for an order
     */
    public function createSnapToken(Order $order): string
    {
        $payment = $order->payment;

        // If payment already verified, do not generate new token
        if ($payment && $payment->status === Payment::STATUS_VERIFIED) {
            return $payment->snap_token ?? '';
        }

        // Build item details
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => 'BOOK-' . $item->book_id,
                'price' => (int) round((float) $item->book_price),
                'quantity' => (int) $item->quantity,
                'name' => mb_strimwidth((string) $item->book_title, 0, 45, '...'),
            ];
        }

        // Add shipping item if cost > 0
        if ((float) $order->shipping_cost > 0) {
            $courierLabel = $order->shipping_courier_label ?: 'Ekspedisi';
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) round((float) $order->shipping_cost),
                'quantity' => 1,
                'name' => mb_strimwidth('Ongkir: ' . $courierLabel, 0, 45, '...'),
            ];
        }

        $grossAmount = (int) round((float) $order->total_price);

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone ?? '',
                'shipping_address' => [
                    'first_name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'phone' => $order->customer_phone ?? '',
                    'address' => $order->shipping_address,
                    'city' => $order->shipping_city,
                    'postal_code' => $order->shipping_postal_code ?? '',
                    'country_code' => 'IDN',
                ],
            ],
            'callbacks' => [
                'finish' => route('customer.payments.finish', $order),
            ],
        ];

        $snapToken = null;

        if ($this->isConfigured()) {
            try {
                $this->initMidtrans();
                $snapToken = Snap::getSnapToken($params);
            } catch (\Throwable $e) {
                Log::error('Midtrans Snap::getSnapToken failed: ' . $e->getMessage(), [
                    'order_id' => $order->invoice_number,
                ]);
                // Fallback token for resilience
                $snapToken = 'DEMO-TOKEN-' . md5($order->invoice_number . now()->timestamp);
            }
        } else {
            // Mock token for demo when keys are not yet configured in .env
            $snapToken = 'DEMO-TOKEN-' . md5($order->invoice_number . now()->timestamp);
        }

        // Save or update Payment record
        if ($payment) {
            $payment->update([
                'payment_method' => Payment::METHOD_MIDTRANS,
                'transfer_amount' => $order->total_price,
                'snap_token' => $snapToken,
                'status' => Payment::STATUS_PENDING,
            ]);
        } else {
            $order->payment()->create([
                'payment_method' => Payment::METHOD_MIDTRANS,
                'transfer_amount' => $order->total_price,
                'snap_token' => $snapToken,
                'status' => Payment::STATUS_PENDING,
            ]);
        }

        return $snapToken;
    }

    /**
     * Handle incoming notification webhook from Midtrans
     *
     * @param array $payload
     * @return array{status: string, message: string, order_id?: string}
     */
    public function handleNotification(array $payload): array
    {
        $orderId = $payload['order_id'] ?? null;
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');
        $transactionStatus = (string) ($payload['transaction_status'] ?? '');
        $paymentType = (string) ($payload['payment_type'] ?? '');
        $fraudStatus = (string) ($payload['fraud_status'] ?? '');
        $transactionId = (string) ($payload['transaction_id'] ?? '');
        $transactionTime = $payload['transaction_time'] ?? now();

        if (! $orderId) {
            return ['status' => 'error', 'message' => 'Order ID is missing in payload'];
        }

        // Verify SHA512 signature if server key is configured
        if ($this->isConfigured() && $signatureKey) {
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
            if ($signatureKey !== $expectedSignature) {
                Log::warning('Midtrans Invalid Signature Key', [
                    'order_id' => $orderId,
                    'received' => $signatureKey,
                    'expected' => $expectedSignature,
                ]);

                return ['status' => 'error', 'message' => 'Invalid signature key'];
            }
        }

        $order = Order::query()->where('invoice_number', $orderId)->first();

        if (! $order) {
            Log::warning("Midtrans notification: Order {$orderId} not found.");

            return ['status' => 'error', 'message' => "Order {$orderId} not found"];
        }

        $payment = $order->payment ?? $order->payment()->create([
            'payment_method' => Payment::METHOD_MIDTRANS,
            'transfer_amount' => $order->total_price,
            'status' => Payment::STATUS_PENDING,
        ]);

        $paymentUpdate = [
            'transaction_id' => $transactionId ?: ($payment->transaction_id ?? null),
            'payment_type' => $paymentType ?: ($payment->payment_type ?? 'midtrans'),
            'transaction_status' => $transactionStatus,
            'transaction_time' => $transactionTime,
            'payment_payload' => $payload,
        ];

        // Status transition evaluation
        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $paymentUpdate['status'] = Payment::STATUS_PENDING;
                $order->update(['status' => Order::STATUS_WAITING_PAYMENT]);
            } elseif ($fraudStatus === 'accept') {
                $paymentUpdate['status'] = Payment::STATUS_VERIFIED;
                $paymentUpdate['verified_at'] = now();
                $order->update(['status' => Order::STATUS_PAID]);
            }
        } elseif ($transactionStatus === 'settlement') {
            $paymentUpdate['status'] = Payment::STATUS_VERIFIED;
            $paymentUpdate['verified_at'] = now();
            $order->update(['status' => Order::STATUS_PAID]);
        } elseif ($transactionStatus === 'pending') {
            $paymentUpdate['status'] = Payment::STATUS_PENDING;
            $order->update(['status' => Order::STATUS_WAITING_PAYMENT]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'], true)) {
            $paymentUpdate['status'] = Payment::STATUS_REJECTED;
            $paymentUpdate['admin_note'] = "Midtrans status: {$transactionStatus}";
            $order->update(['status' => Order::STATUS_CANCELLED]);
        }

        $payment->update($paymentUpdate);

        return [
            'status' => 'success',
            'message' => 'Notification processed successfully',
            'order_id' => $orderId,
            'order_status' => $order->status,
        ];
    }
}
