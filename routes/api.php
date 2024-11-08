<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RefreshController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TestController;
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

Route::group([
   'middleware' => 'api'
], function ($router) {
    Route::get('/test', TestController::class)->middleware('auth:api');
    Route::post('/users', \App\Http\Controllers\User\IndexController::class)->middleware('auth:api');
    Route::post('/user/select', \App\Http\Controllers\User\SelectController::class)->middleware('auth:api');
});
