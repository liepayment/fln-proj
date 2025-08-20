<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('cart', CartController::class)->middleware('auth');
Route::resource('orders', OrderController::class)->middleware('auth');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store')->middleware('auth');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success')->middleware('auth');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel')->middleware('auth');

require __DIR__.'/auth.php';
