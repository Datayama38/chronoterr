<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\V1\ExportController;

Route::prefix('auth')->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'login']);
    // Password (public)
    Route::post('/password/forgot', [PasswordController::class, 'forgot']);
    Route::post('/password/reset', [PasswordController::class, 'reset']);
    // Email verification (signed)
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        // Password (auth)
        Route::post('/password/change', [PasswordController::class, 'change']);
        // Email verification
        Route::post('/email/verification', [EmailVerificationController::class, 'send']);
    });
});
Route::prefix('v1')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('export', [ExportController::class, 'export']);
    });
});
        