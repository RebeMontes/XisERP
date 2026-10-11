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

// Rutas de autenticación
Route::prefix('auth')->group(function () {
    // Login público con protección contra fuerza bruta (máximo 10 intentos por minuto)
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    // Rutas privadas que requieren token JWT válido
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Rutas protegidas del ERP (requieren sesión activa con JWT)
Route::middleware('auth:api')->group(function () {
    // Módulo de usuarios: alternar estado activo/inactivo y CRUD completo
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::apiResource('users', UserController::class);
});
