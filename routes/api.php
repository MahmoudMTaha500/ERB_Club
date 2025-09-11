<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Order processing routes with Saga pattern
Route::middleware('auth:api')->group(function () {
    Route::post('/orders/process', [App\Http\Controllers\OrderController::class, 'processOrder']);
    Route::get('/orders/saga/{sagaId}/status', [App\Http\Controllers\OrderController::class, 'getOrderStatus']);
});

// Demo routes (no auth required for demo purposes)
Route::prefix('demo')->group(function () {
    Route::post('/setup', [App\Http\Controllers\DemoController::class, 'setupDemo']);
    Route::post('/successful-order', [App\Http\Controllers\DemoController::class, 'demoSuccessfulOrder']);
    Route::post('/failed-order', [App\Http\Controllers\DemoController::class, 'demoFailedOrder']);
    Route::get('/status', [App\Http\Controllers\DemoController::class, 'getSystemStatus']);
});
