<?php

use App\Http\Controllers\Api\Plain;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->middleware(['cors', 'json.response'])->group(function () {
    Route::name('register.')->prefix('register')->namespace('Register')->group(function () {
        Route::post('/plain', [Plain::class, 'register'])->name('plain');
    });
    Route::name('login.')->prefix('login')->namespace('Login')->group(function () {
        Route::post('/plain', [Plain::class, 'login'])->name('plain');
    });
});
