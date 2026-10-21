<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CompanyController;
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
    // Módulo de usuarios: exclusivo para usuarios con rol administrador
    Route::middleware('role:admin')->group(function () {
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
        Route::apiResource('users', UserController::class);
    });

    // Módulo de clientes
    Route::patch('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus']);
    Route::apiResource('customers', CustomerController::class);

    // Módulo de empresas
    Route::patch('companies/{company}/toggle-status', [CompanyController::class, 'toggleStatus']);
    Route::apiResource('companies', CompanyController::class);

});
