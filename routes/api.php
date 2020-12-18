<?php

use App\Http\Controllers\Api\Broker;
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
    Route::post('/logout', [Profile::class, 'logout'])->middleware('auth:api')->name('logout');

    // broker endpoints
    Route::name('broker')->prefix('broker')->middleware('auth:api')->group(function () {
        Route::get('/verify-token', [Broker::class, 'verifyToken'])->name('verify_token');
        Route::post('/verify-access', [Broker::class, 'verifyAccess'])->name('verify_access');
    });
});
