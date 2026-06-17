<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BookStockController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;

use App\Http\Controllers\Public\BookCatalogController;

use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/katalog', [BookCatalogController::class, 'index'])->name('books.index');
Route::get('/katalog/{book:slug}', [BookCatalogController::class, 'show'])->name('books.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::resource('categories', CategoryController::class);
            Route::resource('books', BookController::class);

            Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
            Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
            Route::patch('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
            Route::patch('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

            Route::resource('suppliers', SupplierController::class);

            Route::get('/books/{book}/stock', [BookStockController::class, 'edit'])->name('books.stock.edit');
            Route::patch('/books/{book}/stock', [BookStockController::class, 'update'])->name('books.stock.update');

            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
            Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
            Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
            Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
        });

    Route::prefix('customer')
        ->name('customer.')
        ->middleware('customer')
        ->group(function () {
            Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
            Route::post('/cart/{book:slug}', [CartController::class, 'store'])->name('cart.store');
            Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.update');
            Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
            Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

            Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
            Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

            Route::get('/orders/{order}/payment', [CustomerPaymentController::class, 'create'])->name('payments.create');
            Route::post('/orders/{order}/payment', [CustomerPaymentController::class, 'store'])->name('payments.store');
        });
});

require __DIR__.'/auth.php';
