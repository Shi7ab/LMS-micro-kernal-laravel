<?php

use Illuminate\Support\Facades\Route;
use plugins\Auth\src\Http\Controllers\AuthController;

Route::prefix('api/auth')->group(function () {

    Route::post('/register', [
        AuthController::class,
        'register'
    ]);

    Route::post('/login', [
        AuthController::class,
        'login'
    ]);

    Route::middleware('auth.jwt')->get('/me', function () {

        return auth()->user();
    });
});
