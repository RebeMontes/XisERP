<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
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

    // Unidades
    Route::patch('units/{unit}/toggle-status', [UnitController::class, 'toggleStatus']);
    Route::apiResource('units', UnitController::class);

    // Categorías
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus']);
    Route::apiResource('categories', CategoryController::class);

    // Subcategorías
    Route::patch('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus']);
    Route::apiResource('subcategories', SubcategoryController::class);

    // Marcas
    Route::patch('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus']);
    Route::apiResource('brands', BrandController::class);

    // Productos
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus']);
    Route::apiResource('products', ProductController::class);

});
