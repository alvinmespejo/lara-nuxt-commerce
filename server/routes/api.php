<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\SigninController;
use App\Http\Controllers\Api\v1\Auth\SignupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::prefix('/v1/auth')->group(function () {
// });

Route::group(['prefix' => '/v1/auth'], function () {

    Route::post('/signin', [SigninController::class, 'signin']);
    Route::post('/signup', [SignupController::class, 'signup']);

    Route::get('/me', [AuthController::class, 'me'])->middleware(['jwt']);
    Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('jwt');
    Route::post('/signout', [AuthController::class, 'signout'])->middleware('jwt');
});
