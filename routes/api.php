<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController; // Agregamos el controlador de categorías


// Rutas de autenticación
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
});

// Rutas de usuarios
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
});

// Rutas de categorías
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/categories', CategoryController::class);
});