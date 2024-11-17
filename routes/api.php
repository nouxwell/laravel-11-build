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
    Route::post('/login/check', \App\Http\Controllers\Auth\LoginCheckController::class);
    Route::post('/login/qr-code', \App\Http\Controllers\Auth\GenerateLoginQrCodeController::class);
    Route::post('/profile', ProfileController::class)->middleware('auth:api');
    Route::post('/refresh', RefreshController::class)->middleware('auth:api');
    Route::post('/logout', LogoutController::class)->middleware('auth:api');
    Route::post('/enable-2fa', \App\Http\Controllers\Auth\EnableTwoFactorController::class)->middleware('auth:api');
    Route::post('/disable-2fa', \App\Http\Controllers\Auth\DisableTwoFactorController::class)->middleware('auth:api');
    Route::post('/reset-2fa', \App\Http\Controllers\Auth\ResetTwoFactorController::class)->middleware('auth:api');
})->middleware(Localization::class);

Route::get('/email/verify/{id}', \App\Http\Controllers\Auth\VerifyController::class)->name('verification.verify')->middleware('signed');
Route::get('/test', TestController::class);
Route::get('/mail/test', \App\Http\Controllers\MailController::class);

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::post('/users', \App\Http\Controllers\User\IndexController::class)->middleware('auth:api');
    Route::post('/users/export', \App\Http\Controllers\User\DatatableExportController::class)->middleware('auth:api');
    Route::post('/user/select', \App\Http\Controllers\User\SelectController::class)->middleware('auth:api');
});


