<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


use App\Http\Controllers\Auth\SupplierAuthController;
use App\Http\Controllers\Auth\BrandAuthController;

Route::prefix('supplier')->group(function () {
    Route::post('register', [SupplierAuthController::class, 'register']);
    Route::post('login', [SupplierAuthController::class, 'login']);
    Route::get('logout', [SupplierAuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('brand')->group(function () {
    Route::post('register', [BrandAuthController::class, 'register']);
    Route::post('login', [BrandAuthController::class, 'login']);
    Route::get('logout', [BrandAuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('getCategories', [GeneralController::class, 'getAllCategories']);
    Route::get('getColors', [GeneralController::class, 'getAllColors']);

    Route::prefix('products')->middleware('auth.supplier')->group(function () {
        Route::get('/',[ProductController::class, 'index']);
        Route::post('/',[ProductController::class, 'store']);
        Route::put('/{product}',[ProductController::class, 'update']);
        Route::get('/{product}',[ProductController::class, 'show']);
        Route::delete('/{product}',[ProductController::class, 'destroy']);
        Route::patch('/{product}', [ProductController::class, 'restore']);

    });

    Route::prefix('suppliers')->group(function () {
        Route::get('search/{category?}', [BrandController::class, 'getSuppliersByCategory']);
        Route::get('products/{supplier}', [BrandController::class, 'getProductsBySupplier']);
    });
    Route::post('/upload', [UploadController::class, 'upload']);

});




