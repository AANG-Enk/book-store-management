<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
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
                        ->orWhere('customer_phone', 'like', "%{$search}%")
                        ->orWhere('tracking_number', 'like', "%{$search}%")
                        ->orWhere('shipping_courier', 'like', "%{$search}%");
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

        $nextStatus = $validated['status'];

        if ($nextStatus === Order::STATUS_PAID && $order->payment?->status !== Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Order tidak bisa diubah menjadi sudah dibayar sebelum pembayaran diverifikasi.');
        }

        if ($nextStatus === Order::STATUS_PROCESSING && $order->payment?->status !== Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Order tidak bisa diproses sebelum pembayaran diverifikasi.');
        }

        if ($nextStatus === Order::STATUS_SHIPPED && blank($order->tracking_number)) {
            return back()->with('error', 'Nomor resi wajib diisi sebelum pesanan ditandai dikirim.');
        }

        if ($nextStatus === Order::STATUS_COMPLETED && ! in_array($order->status, [Order::STATUS_SHIPPED, Order::STATUS_PROCESSING, Order::STATUS_PAID], true)) {
            return back()->with('error', 'Order hanya bisa diselesaikan setelah dibayar/diproses/dikirim.');
        }

        $payload = ['status' => $nextStatus];

        if ($nextStatus === Order::STATUS_SHIPPED && blank($order->shipped_at)) {
            $payload['shipped_at'] = now();
        }

        $order->update($payload);

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
            'mark_shipped' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('mark_shipped') && blank($validated['tracking_number'] ?? $order->tracking_number)) {
            return back()->withInput()->with('error', 'Nomor resi wajib diisi jika ingin langsung menandai pesanan dikirim.');
        }

        if ($request->boolean('mark_shipped') && $order->payment?->status !== Payment::STATUS_VERIFIED) {
            return back()->withInput()->with('error', 'Pesanan belum bisa ditandai dikirim sebelum pembayaran diverifikasi.');
        }

        $subtotalPrice = (float) $order->subtotal_price;

        if ($subtotalPrice <= 0) {
            $subtotalPrice = (float) $order->items()->sum('subtotal');
        }

        $shippingCost = (float) $validated['shipping_cost'];
        $nextStatus = $order->status === Order::STATUS_WAITING_SHIPPING
            ? Order::STATUS_WAITING_PAYMENT
            : $order->status;

        if ($request->boolean('mark_shipped')) {
            $nextStatus = Order::STATUS_SHIPPED;
        }

        $order->update([
            'subtotal_price' => $subtotalPrice,
            'shipping_courier' => $validated['shipping_courier'] ?? null,
            'shipping_service' => $validated['shipping_service'] ?? null,
            'shipping_cost' => $shippingCost,
            'tracking_number' => $validated['tracking_number'] ?? null,
            'shipping_confirmed_at' => $order->shipping_confirmed_at ?? now(),
            'shipped_at' => $request->boolean('mark_shipped')
                ? ($validated['shipped_at'] ?? now())
                : ($validated['shipped_at'] ?? null),
            'total_price' => $subtotalPrice + $shippingCost,
            'status' => $nextStatus,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', $request->boolean('mark_shipped')
                ? 'Informasi pengiriman disimpan dan pesanan ditandai dikirim.'
                : 'Informasi pengiriman dan ongkir berhasil diperbarui.');
    }

    public function markProcessing(Order $order): RedirectResponse
    {
        if ($order->payment?->status !== Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Pesanan belum bisa diproses sebelum pembayaran diverifikasi.');
        }

        $order->update([
            'status' => Order::STATUS_PROCESSING,
        ]);

        return back()->with('success', 'Pesanan berhasil ditandai sedang diproses.');
    }

    public function markShipped(Request $request, Order $order): RedirectResponse
    {
        if ($order->payment?->status !== Payment::STATUS_VERIFIED) {
            return back()->with('error', 'Pesanan belum bisa dikirim sebelum pembayaran diverifikasi.');
        }

        $validated = $request->validate([
            'shipping_courier' => ['nullable', 'string', 'max:100'],
            'shipping_service' => ['nullable', 'string', 'max:100'],
            'tracking_number' => ['required', 'string', 'max:100'],
            'shipped_at' => ['nullable', 'date'],
        ]);

        $order->update([
            'shipping_courier' => $validated['shipping_courier'] ?? $order->shipping_courier,
            'shipping_service' => $validated['shipping_service'] ?? $order->shipping_service,
            'tracking_number' => $validated['tracking_number'],
            'shipped_at' => $validated['shipped_at'] ?? now(),
            'status' => Order::STATUS_SHIPPED,
        ]);

        return back()->with('success', 'Pesanan berhasil ditandai dikirim.');
    }

    public function markCompleted(Order $order): RedirectResponse
    {
        if (! in_array($order->status, [Order::STATUS_SHIPPED, Order::STATUS_PROCESSING, Order::STATUS_PAID], true)) {
            return back()->with('error', 'Pesanan belum bisa diselesaikan dari status saat ini.');
        }

        $order->update([
            'status' => Order::STATUS_COMPLETED,
        ]);

        return back()->with('success', 'Pesanan berhasil ditandai selesai.');
    }

    private function statuses(): array
    {
        return [
            Order::STATUS_WAITING_SHIPPING => 'Menunggu Ongkir',
            Order::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            Order::STATUS_PAID => 'Sudah Dibayar',
            Order::STATUS_PROCESSING => 'Diproses',
            Order::STATUS_SHIPPED => 'Dikirim',
            Order::STATUS_COMPLETED => 'Selesai',
            Order::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }
}
