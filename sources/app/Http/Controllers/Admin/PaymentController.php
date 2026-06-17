<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $payments = Payment::query()
            ->with('order.user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('sender_name', 'like', "%{$search}%")
                        ->orWhere('bank_name', 'like', "%{$search}%")
                        ->orWhereHas('order', function ($orderQuery) use ($search) {
                            $orderQuery
                                ->where('invoice_number', 'like', "%{$search}%")
                                ->orWhere('customer_name', 'like', "%{$search}%")
                                ->orWhere('customer_email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payments.index', compact('payments', 'search', 'status'));
    }

    public function show(Payment $payment): View
    {
        $payment->load(['order.items.book.category', 'order.user']);

        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Payment $payment): RedirectResponse
    {
        if ($payment->status === Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Pembayaran sudah diverifikasi.');
        }

        $payment->update([
            'status' => Payment::STATUS_VERIFIED,
            'admin_note' => null,
            'verified_at' => now(),
        ]);

        $payment->order->update([
            'status' => Order::STATUS_PAID,
        ]);

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        if ($payment->status === Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Pembayaran yang sudah diverifikasi tidak bisa ditolak.');
        }

        $payment->update([
            'status' => Payment::STATUS_REJECTED,
            'admin_note' => $validated['admin_note'],
            'verified_at' => null,
        ]);

        $payment->order->update([
            'status' => Order::STATUS_WAITING_PAYMENT,
        ]);

        return redirect()
            ->route('admin.payments.show', $payment)
            ->with('success', 'Pembayaran ditolak. Customer dapat upload ulang bukti pembayaran.');
    }
}
