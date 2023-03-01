<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\UserController;
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

Route::prefix('user')->group(function () {
    Route::post('register', [UserController::class, 'register'])->name('user.register');
    Route::post('login', [UserController::class, 'login'])->name('user.login');
    Route::get('send/email/verification/link/{user}', [UserController::class, 'sendEmailVerificationLink'])->name('user.send.email.verification.link');
    Route::post('send/password/reset/link', [UserController::class, 'sendPasswordResetLink'])->name('user.send.password.reset.link');
});
