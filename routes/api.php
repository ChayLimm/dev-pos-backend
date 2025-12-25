<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


// Handle preflight OPTIONS requests for all API routes
Route::options('/{any}', function () {
    return response()->json([], 200)
        ->header('Access-Control-Allow-Origin', 'https://devops-project-production-7653.up.railway.app')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept');
})->where('any', '.*');


// Products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber('id');
Route::put('/products/{id}', [ProductController::class, 'update'])->whereNumber('id');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->whereNumber('id');

// Orders + Receipt
Route::get('/orders/{order_number}/receipt', [OrderController::class, 'receiptByNumber']);
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show'])->whereNumber('id');
Route::put('/orders/{id}', [OrderController::class, 'update'])->whereNumber('id');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->whereNumber('id');