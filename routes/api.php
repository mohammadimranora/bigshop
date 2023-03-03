<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductMediaController;
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

Route::prefix('v1/user')->group(function () {
    Route::post('register', [UserController::class, 'register'])->name('user.register');
    Route::post('login', [UserController::class, 'login'])->name('user.login');
    Route::get('send/email/verification/link/{user}', [UserController::class, 'sendEmailVerificationLink'])->name('user.send.email.verification.link');
    Route::post('send/password/reset/link', [UserController::class, 'sendPasswordResetLink'])->name('user.send.password.reset.link');
});


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
    Route::get('product/view/count/{product}', [ProductController::class, 'productView']);
    Route::apiResource('media', ProductMediaController::class);
});
