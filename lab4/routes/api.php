<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\CheckoutStateController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;

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
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::get('unauthorized', [AuthController::class, 'handleUnauthorizedRequest'])->name('unauthorized');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('checkout-states', CheckoutStateController::class);
    Route::resource('product_categories', ProductCategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('products', ProductController::class);
    Route::resource('carts', CartController::class);
    Route::resource('checkouts', CheckoutController::class);
});
