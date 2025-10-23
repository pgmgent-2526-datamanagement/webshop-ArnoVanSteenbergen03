<?php

use App\Http\Controllers\WebshopController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/webshop', [WebshopController::class, 'list'])->name('webshop.list');
Route::get('/webshop/{id}', [WebshopController::class, 'detail'])->name('webshop.detail');

Route::get('/cart', [ShoppingCartController::class, 'shoppingCart'])->name('cart.index');
Route::post('/cart/add/{id}', [ShoppingCartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [ShoppingCartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [ShoppingCartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [ShoppingCartController::class, 'clearCart'])->name('cart.clear');