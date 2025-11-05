<?php

use App\Http\Controllers\WebshopController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// webshop routes
Route::get('/webshop', [WebshopController::class, 'list'])->name('webshop.list');
Route::get('/webshop/{id}', [WebshopController::class, 'detail'])->name('webshop.detail');

// cart routes
Route::get('/cart', [ShoppingCartController::class, 'shoppingCart'])->name('cart.index');
Route::post('/cart/add/{id}', [ShoppingCartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [ShoppingCartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [ShoppingCartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [ShoppingCartController::class, 'clearCart'])->name('cart.clear');

//mollie routes
Route::get('/checkout', [ShoppingCartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/submit', [ShoppingCartController::class, 'processCheckout'])->name('cart.checkout.submit');
Route::get('/checkout/success', [ShoppingCartController::class, 'checkoutSuccess'])->name('cart.checkout.success');
Route::get('/checkout/cancel', [ShoppingCartController::class, 'checkoutCancel'])->name('cart.checkout.cancel');
Route::post('/webhooks/mollie', [ShoppingCartController::class, 'webhook'])->name('webhooks.mollie');