<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your ERP application.
|
*/

Route::prefix('auth')->group(function () {
    // Public routes (with brute-force protection rate limiting)
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    // Authenticated routes
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Protected ERP Resource Routes
Route::middleware('auth:api')->group(function () {
    // Módulo de Usuarios
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::apiResource('users', UserController::class);
});
