<?php

use App\Http\Controllers\Api\Plain;
use App\Http\Controllers\Api\Profile;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->middleware(['cors', 'json.response'])->group(function () {
    Route::name('register.')->prefix('register')->group(function () {
        Route::post('/plain', [Plain::class, 'register'])->name('plain');
    });
    Route::name('login.')->prefix('login')->group(function () {
        Route::post('/plain', [Plain::class, 'login'])->name('plain');
    });
    Route::name('profile.')->prefix('profile')->middleware('auth:api')->group(function () {
        Route::get('/', [Profile::class, 'get'])->name('get');
        Route::post('/', [Profile::class, 'update'])->name('update');
    });
});
