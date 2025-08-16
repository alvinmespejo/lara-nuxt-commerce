<?php

use App\Http\Controllers\Api\v1\AddressController;
use App\Http\Controllers\Api\v1\AddressShippingController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\SigninController;
use App\Http\Controllers\Api\v1\Auth\SignupController;
use App\Http\Controllers\Api\v1\CartController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => '/v1'], function () {
    /** Authentication route */
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/signin', [SigninController::class, 'signin']);
        Route::post('/signup', [SignupController::class, 'signup']);
        Route::post('/signinv2', [SigninController::class, 'signinv2']);

        Route::get('/me', [AuthController::class, 'me'])->middleware(['jwt']);
        Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('jwt');
        Route::post('/signout', [AuthController::class, 'signout'])->middleware('jwt');
    });

    Route::group(['middleware' => 'jwt'], function () {
        Route::get('/addresses/{address}/shipping', [AddressShippingController::class, 'show']);
        Route::apiResource('countries', CountryController::class);
        Route::apiResource('addresses', AddressController::class);
        Route::apiResource('orders', OrderController::class);
    });


    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('payment-methods', PaymentMethodController::class);
    Route::apiResource('cart', CartController::class)->parameters([
        'cart' => 'productVariation'
    ]);
});
