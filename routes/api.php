<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::prefix('store')->group(function () {
        Route::get('/config', [\App\Http\Controllers\Api\Store\ConfigController::class, 'index']);
        Route::get('/categories', [\App\Http\Controllers\Api\Store\CategoryController::class, 'index']);
        Route::get('/products', [\App\Http\Controllers\Api\Store\ProductController::class, 'index']);
        Route::get('/products/{slug}', [\App\Http\Controllers\Api\Store\ProductController::class, 'show']);
        Route::post('/orders', [\App\Http\Controllers\Api\Store\OrderController::class, 'store']);
        Route::get('/orders/track', [\App\Http\Controllers\Api\Store\OrderController::class, 'track']);
        Route::get('/orders/{id}', [\App\Http\Controllers\Api\Store\OrderController::class, 'show']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
        Route::post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [\App\Http\Controllers\Api\Auth\AuthController::class, 'me'])->middleware('auth:sanctum');
    });

    Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);
        Route::apiResource('/categories', \App\Http\Controllers\Api\Admin\CategoryController::class);
        Route::apiResource('/products', \App\Http\Controllers\Api\Admin\ProductController::class);
        Route::apiResource('/orders', \App\Http\Controllers\Api\Admin\OrderController::class)->only(['index', 'update']);
        Route::get('/settings', [\App\Http\Controllers\Api\Admin\ConfigController::class, 'index']);
        Route::put('/settings', [\App\Http\Controllers\Api\Admin\ConfigController::class, 'update']);
    });
});
