<?php

use App\Http\Controllers\WebshopController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/webshop', [WebshopController::class, 'list'])->name('webshop.list');
Route::get('/webshop/{id}', [WebshopController::class, 'detail'])->name('webshop.detail');