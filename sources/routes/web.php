<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BookStockController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ContactMessageController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;

use App\Http\Controllers\Public\BookCatalogController;
use App\Http\Controllers\Public\PageController;

use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/katalog', [BookCatalogController::class, 'index'])->name('books.index');
Route::get('/katalog/{book:slug}', [BookCatalogController::class, 'show'])->name('books.show');

Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'submitContact'])->name('contact.submit');

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
            Route::patch('/orders/{order}/shipping', [AdminOrderController::class, 'updateShipping'])->name('orders.update-shipping');
            Route::patch('/orders/{order}/mark-processing', [AdminOrderController::class, 'markProcessing'])->name('orders.mark-processing');
            Route::patch('/orders/{order}/mark-shipped', [AdminOrderController::class, 'markShipped'])->name('orders.mark-shipped');
            Route::patch('/orders/{order}/mark-completed', [AdminOrderController::class, 'markCompleted'])->name('orders.mark-completed');

            Route::resource('suppliers', SupplierController::class);

            Route::get('/books/{book}/stock', [BookStockController::class, 'edit'])->name('books.stock.edit');
            Route::patch('/books/{book}/stock', [BookStockController::class, 'update'])->name('books.stock.update');

            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
            Route::get('/reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
            Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
            Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');

            Route::get('/reports/sales/export', [ReportController::class, 'exportSales'])->name('reports.sales.export');
            Route::get('/reports/payments/export', [ReportController::class, 'exportPayments'])->name('reports.payments.export');
            Route::get('/reports/stocks/export', [ReportController::class, 'exportStocks'])->name('reports.stocks.export');
            Route::get('/reports/customers/export', [ReportController::class, 'exportCustomers'])->name('reports.customers.export');

            Route::get('/reports/sales/pdf', [ReportController::class, 'exportSalesPdf'])->name('reports.sales.pdf');
            Route::get('/reports/payments/pdf', [ReportController::class, 'exportPaymentsPdf'])->name('reports.payments.pdf');
            Route::get('/reports/stocks/pdf', [ReportController::class, 'exportStocksPdf'])->name('reports.stocks.pdf');
            Route::get('/reports/customers/pdf', [ReportController::class, 'exportCustomersPdf'])->name('reports.customers.pdf');

            Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
            Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
            Route::patch('/contact-messages/{contactMessage}/read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.read');
            Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
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
