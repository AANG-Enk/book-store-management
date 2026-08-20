<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function create(Order $order): View|RedirectResponse
    {
        $this->authorizeOrder($order);

        if (in_array($order->status, [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_COMPLETED], true)) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('success', 'Pesanan ini sudah dibayar.');
        }

        if ($order->status === Order::STATUS_WAITING_SHIPPING) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('error', 'Pesanan masih menunggu ongkos kirim.');
        }

        $order->load(['items.book', 'payment']);

        $snapToken = $this->midtransService->createSnapToken($order);
        $clientKey = $this->midtransService->getClientKey();
        $snapScriptUrl = $this->midtransService->getSnapScriptUrl();
        $isConfigured = $this->midtransService->isConfigured();

        return view('customer.payments.create', compact(
            'order',
            'snapToken',
            'clientKey',
            'snapScriptUrl',
            'isConfigured'
        ));
    }

    public function finish(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        $orderId = $request->string('order_id')->toString();
        $statusCode = $request->string('status_code')->toString();
        $transactionStatus = $request->string('transaction_status')->toString();

        // If redirected from Midtrans Snap success
        if (in_array($statusCode, ['200', '201'], true) || in_array($transactionStatus, ['settlement', 'capture', 'pending'], true)) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('success', 'Pembayaran sedang/telah diproses oleh Midtrans.');
        }

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('info', 'Status transaksi telah diperbarui.');
    }

    /**
     * Simulation method for presentation / thesis testing when sandbox keys are pending
     */
    public function simulateSuccess(Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        $this->midtransService->handleNotification([
            'order_id' => $order->invoice_number,
            'status_code' => '200',
            'gross_amount' => (string) round((float) $order->total_price),
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'transaction_id' => 'MOCK-' . uniqid(),
            'transaction_time' => now()->toDateTimeString(),
        ]);

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Simulasi Pembayaran Berhasil! Status pesanan otomatis menjadi Sudah Dibayar (paid).');
    }

    private function authorizeOrder(Order $order): void
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if(! auth()->user()->isCustomer(), 403);
    }
}
