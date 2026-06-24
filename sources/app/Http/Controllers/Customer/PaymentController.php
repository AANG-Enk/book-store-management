<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(Order $order): View|RedirectResponse
    {
        $this->authorizeOrder($order);

        if ($order->status === Order::STATUS_WAITING_SHIPPING) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('error', 'Pesanan masih menunggu admin menentukan ongkos kirim.');
        }

        abort_if(
            ! in_array($order->status, [
                Order::STATUS_WAITING_PAYMENT,
                Order::STATUS_PENDING,
            ], true),
            403
        );

        $order->load('payment');

        return view('customer.payments.create', compact('order'));
    }

    public function store(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        if ($order->status === Order::STATUS_WAITING_SHIPPING) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('error', 'Pesanan masih menunggu admin menentukan ongkos kirim.');
        }

        abort_if(
            ! in_array($order->status, [
                Order::STATUS_WAITING_PAYMENT,
                Order::STATUS_PENDING,
            ], true),
            403
        );

        $validated = $request->validate([
            'bank_name' => ['nullable', 'string', 'max:100'],
            'sender_name' => ['required', 'string', 'max:150'],
            'transfer_amount' => ['required', 'numeric', 'min:1'],
            'proof_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $payment = $order->payment;

        if ($payment && $payment->status === Payment::STATUS_VERIFIED) {
            return redirect()
                ->route('customer.orders.show', $order)
                ->with('error', 'Pembayaran sudah diverifikasi dan tidak bisa diubah.');
        }

        $proofPath = $request->file('proof_image')
            ->store('payments/proofs', 'public');

        if ($payment) {
            if ($payment->proof_image) {
                Storage::disk('public')->delete($payment->proof_image);
            }

            $payment->update([
                'bank_name' => $validated['bank_name'] ?? null,
                'sender_name' => $validated['sender_name'],
                'transfer_amount' => $validated['transfer_amount'],
                'proof_image' => $proofPath,
                'status' => Payment::STATUS_PENDING,
                'admin_note' => null,
                'verified_at' => null,
            ]);
        } else {
            $order->payment()->create([
                'payment_method' => 'bank_transfer',
                'bank_name' => $validated['bank_name'] ?? null,
                'sender_name' => $validated['sender_name'],
                'transfer_amount' => $validated['transfer_amount'],
                'proof_image' => $proofPath,
                'status' => Payment::STATUS_PENDING,
            ]);
        }

        $order->update([
            'status' => Order::STATUS_WAITING_PAYMENT,
        ]);

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diupload. Silakan tunggu verifikasi admin.');
    }

    private function authorizeOrder(Order $order): void
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if(! auth()->user()->isCustomer(), 403);
    }
}
