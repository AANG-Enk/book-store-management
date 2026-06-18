<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $cartItemsCount = CartItem::query()
            ->where('user_id', auth()->id())
            ->sum('quantity');

        $ordersCount = Order::query()
            ->where('user_id', auth()->id())
            ->count();

        $latestOrders = Order::query()
            ->with('payment')
            ->where('user_id', auth()->id())
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact(
            'cartItemsCount',
            'ordersCount',
            'latestOrders'
        ));
    }
}
