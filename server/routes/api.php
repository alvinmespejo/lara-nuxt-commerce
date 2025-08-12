<?php

use App\Http\Controllers\Api\v1\AddressController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\SigninController;
use App\Http\Controllers\Api\v1\Auth\SignupController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\ProductController;
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

        Route::get('/me', [AuthController::class, 'me'])->middleware(['jwt']);
        Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('jwt');
        Route::post('/signout', [AuthController::class, 'signout'])->middleware('jwt');
    });

    Route::group(['middleware' => 'jwt'], function () {
        Route::resource('countries', CountryController::class);
        Route::resource('addresses', AddressController::class);


    });

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});
