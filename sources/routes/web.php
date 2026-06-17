<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\CartController;

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
        });
});

require __DIR__.'/auth.php';
