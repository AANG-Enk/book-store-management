<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Keranjang masih kosong. Tambahkan buku terlebih dahulu.');
        }

        $cartTotal = $cartItems->sum(fn (CartItem $item) => $item->subtotal);
        $totalWeight = $cartItems->sum(fn (CartItem $item) => $item->quantity * ($item->book->weight ?: 250));
        $totalWeight = max(1, $totalWeight);

        $formattedWeight = $totalWeight >= 1000
            ? rtrim(rtrim(number_format($totalWeight / 1000, 2, ',', '.'), '0'), ',') . ' kg'
            : $totalWeight . ' gram';

        return view('customer.checkout.create', compact('cartItems', 'cartTotal', 'totalWeight', 'formattedWeight'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_province' => ['required', 'string', 'max:100'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['nullable', 'string', 'max:20'],
            'shipping_courier' => ['required', 'string', 'max:50'],
            'shipping_service' => ['required', 'string', 'max:50'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Keranjang masih kosong. Tambahkan buku terlebih dahulu.');
        }

        foreach ($cartItems as $cartItem) {
            if (! $cartItem->book->is_active || ! $cartItem->book->category?->is_active) {
                return redirect()
                    ->route('customer.cart.index')
                    ->with('error', 'Ada buku yang sudah tidak tersedia. Silakan periksa kembali keranjang.');
            }

            if ($cartItem->quantity > $cartItem->book->stock) {
                return redirect()
                    ->route('customer.cart.index')
                    ->with('error', 'Jumlah buku melebihi stok tersedia. Silakan update keranjang.');
            }
        }

        $order = DB::transaction(function () use ($validated, $cartItems) {
            $subtotalPrice = $cartItems->sum(fn (CartItem $item) => $item->subtotal);
            $shippingCost = (float) $validated['shipping_cost'];
            $totalPrice = $subtotalPrice + $shippingCost;

            $order = Order::query()->create([
                'user_id' => auth()->id(),
                'invoice_number' => $this->generateInvoiceNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'shipping_province' => $validated['shipping_province'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'shipping_courier' => strtoupper($validated['shipping_courier']),
                'shipping_service' => $validated['shipping_service'],
                'shipping_cost' => $shippingCost,
                'shipping_confirmed_at' => now(),
                'subtotal_price' => $subtotalPrice,
                'total_price' => $totalPrice,
                'status' => Order::STATUS_WAITING_PAYMENT,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $cartItem) {
                $book = Book::query()
                    ->whereKey($cartItem->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($cartItem->quantity > $book->stock) {
                    throw new \RuntimeException('Stok buku tidak mencukupi.');
                }

                $subtotal = (float) $book->price * $cartItem->quantity;

                $order->items()->create([
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'book_price' => $book->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $subtotal,
                ]);

                $book->decrement('stock', $cartItem->quantity);
            }

            CartItem::query()
                ->where('user_id', auth()->id())
                ->delete();

            return $order;
        });

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat dengan ongkos kirim otomatis. Silakan lanjutkan pembayaran.');
    }

    private function getCartItems()
    {
        return CartItem::query()
            ->with(['book.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');

        $latestOrder = Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->latest('id')
            ->first();

        $sequence = $latestOrder
            ? ((int) substr($latestOrder->invoice_number, -4)) + 1
            : 1;

        return 'INV-' . $date . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
