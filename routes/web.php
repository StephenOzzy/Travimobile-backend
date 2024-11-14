<?php

use App\Http\Controllers\auth\ForgotPasswordEmailController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\SendTestMailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/logout', [AuthenticateController::class, 'logout']);// ->middleware('auth:api');

Route::prefix('auth')
->withoutMiddleware([Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
->group(function(){
    Route::post('/signup', [RegisterController::class, 'signup']);
    Route::post('/login', [AuthenticateController::class, 'login']);
    Route::post('/forgot-password-email', [ForgotPasswordEmailController::class, 'send_password_reset_link']);
    Route::get('/reset-password', [])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
});

Route::get('/send-test-mail', [SendTestMailController::class, 'sendTestMail']);
