<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/profile', ProfileController::class)->middleware('auth:api');
    Route::post('/refresh', RefreshController::class)->middleware('auth:api');
    Route::post('/logout', LogoutController::class)->middleware('auth:api');
})->middleware(Localization::class);

