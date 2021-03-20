<?php

use App\Http\Controllers\Api\Applications;
use App\Http\Controllers\Api\Broker;
use App\Http\Controllers\Api\Plain;
use App\Http\Controllers\Api\Profile;
use App\Http\Controllers\Api\Sessions;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->middleware(['cors', 'json.response'])->group(function () {
    Route::name('register.')->prefix('register')->group(function () {
        Route::post('/plain', [Plain::class, 'register'])->name('plain');
    });
    Route::name('login.')->prefix('login')->group(function () {
        Route::post('/plain', [Plain::class, 'login'])->name('plain');
    });
    Route::middleware("auth:api")->group(function () {
        Route::name('profile.')->prefix('profile')->group(function () {
            Route::get('/', [Profile::class, 'get'])->name('get');
            Route::post('/', [Profile::class, 'update'])->name('update');
        });
        Route::name("sessions.")->prefix("/sessions")->group(function () {
            Route::get("/", [Sessions::class, "list"])->name("list");
            Route::delete("/all-but-me", [Sessions::class, "deleteAllButMe"])->name("deleteAllButMe");
            Route::delete("/{token}", [Sessions::class, "delete"])->name("delete");
        });
        Route::name("applications.")->prefix("/applications")->group(function () {
            Route::get("/", [Applications::class, "index"])->name("index");
            Route::post("/", [Applications::class, "create"])->name("create");
            Route::post("/{application}", [Applications::class, "edit"])->name("edit");
            Route::delete("/{application}", [Applications::class, "delete"])->name("delete");
            Route::post("/{application}/refresh-token", [Applications::class, "refreshToken"])->name("refreshToken");
        });
        Route::post('/logout', [Profile::class, 'logout'])->name('logout');
    });

    // broker endpoints
    Route::name('broker')->prefix('broker')->middleware('auth:api')->group(function () {
        Route::get('/verify-token', [Broker::class, 'verifyToken'])->name('verify_token');
        Route::post('/verify-access', [Broker::class, 'verifyAccess'])->name('verify_access');
    });

    // deploy apis
    Route::get('/update/' . env('APP_KEY'), []);
});
