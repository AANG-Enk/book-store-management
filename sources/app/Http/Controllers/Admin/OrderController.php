<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with(['user', 'payment'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('invoice_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = $this->statuses();

        return view('admin.orders.index', compact('orders', 'search', 'status', 'statuses'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.book.category', 'payment']);

        $statuses = $this->statuses();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in(array_keys($this->statuses())),
            ],
        ]);

        if (
            $validated['status'] === Order::STATUS_PAID
            && $order->payment?->status !== \App\Models\Payment::STATUS_VERIFIED
        ) {
            return back()->with('error', 'Order tidak bisa diubah menjadi paid sebelum pembayaran diverifikasi.');
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateShipping(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_courier' => ['nullable', 'string', 'max:100'],
            'shipping_service' => ['nullable', 'string', 'max:100'],
            'shipping_cost' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'shipped_at' => ['nullable', 'date'],
        ]);

        $subtotalPrice = (float) $order->subtotal_price;

        if ($subtotalPrice <= 0) {
            $subtotalPrice = (float) $order->items()->sum('subtotal');
        }

        $shippingCost = (float) $validated['shipping_cost'];
        $nextStatus = $order->status === Order::STATUS_WAITING_SHIPPING
            ? Order::STATUS_WAITING_PAYMENT
            : $order->status;

        $order->update([
            'subtotal_price' => $subtotalPrice,
            'shipping_courier' => $validated['shipping_courier'] ?? null,
            'shipping_service' => $validated['shipping_service'] ?? null,
            'shipping_cost' => $shippingCost,
            'tracking_number' => $validated['tracking_number'] ?? null,
            'shipping_confirmed_at' => $order->shipping_confirmed_at ?? now(),
            'shipped_at' => $validated['shipped_at'] ?? null,
            'total_price' => $subtotalPrice + $shippingCost,
            'status' => $nextStatus,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Informasi pengiriman dan ongkir berhasil diperbarui.');
    }

    private function statuses(): array
    {
        return [
            Order::STATUS_WAITING_SHIPPING => 'Menunggu Ongkir',
            Order::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            Order::STATUS_PAID => 'Sudah Dibayar',
            Order::STATUS_PROCESSING => 'Diproses',
            Order::STATUS_COMPLETED => 'Selesai',
            Order::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }
}
