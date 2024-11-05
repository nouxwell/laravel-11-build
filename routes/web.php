<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'test'], function () {
    Route::get('/', [\App\Http\Controllers\TestController::class, 'index']); // Tüm ürünleri görüntüleme
});
