
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\MobileAuthController;
use App\Http\Controllers\Api\SkillProfileController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\LamaranController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel API berhasil',
    ]);
});

Route::prefix('mobile')->group(function () {
    Route::post(
        '/register',
        [MobileAuthController::class, 'register']
    );

    Route::post(
        '/complete-registration',
        [MobileAuthController::class, 'completeRegistration']
    );

    Route::post('/login', [MobileAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MobileAuthController::class, 'me']);
        Route::post('/logout', [MobileAuthController::class, 'logout']);

        Route::get(
            '/skill-profile',
            [SkillProfileController::class, 'show']
        );

        Route::post(
            '/skill-profile',
            [SkillProfileController::class, 'store']
        );
        Route::get('/riwayat-lamaran', [LamaranController::class, 'index']
        );
        Route::post('/profile/photo', [MobileAuthController::class, 'updatePhoto']);
    });
    Route::get('/pekerjaan', [PekerjaanController::class, 'index']);
});
