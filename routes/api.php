<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\MobileAuthController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel API berhasil',
    ]);
});

Route::prefix('mobile')->group(function () {
    Route::post('/register', [MobileAuthController::class, 'register']);
    Route::post('/login', [MobileAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MobileAuthController::class, 'me']);
        Route::post('/logout', [MobileAuthController::class, 'logout']);
    });
});