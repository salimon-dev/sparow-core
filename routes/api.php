<?php

use App\Http\Controllers\Api\Applications;
use App\Http\Controllers\Api\Broker;
use App\Http\Controllers\Api\Permissions;
use App\Http\Controllers\Api\Plain;
use App\Http\Controllers\Api\Profile;
use App\Http\Controllers\Api\RedirectUrls;
use App\Http\Controllers\Api\Sessions;
use App\Http\Controllers\Api\ValidDomains;
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
        Route::name('permissions.')->prefix('permissions')->group(function () {
            Route::get("/", [Permissions::class, "mine"])->name("mine");
        });
        Route::name("sessions.")->prefix("/sessions")->group(function () {
            Route::get("/", [Sessions::class, "list"])->name("list");
            Route::delete("/all-but-me", [Sessions::class, "deleteAllButMe"])->name("deleteAllButMe");
            Route::delete("/{token}", [Sessions::class, "delete"])->name("delete");
        });
        Route::name("applications.")->prefix("/applications")->middleware("hasPermission:applications")->group(function () {
            Route::get("/", [Applications::class, "index"])->name("index");
            Route::post("/", [Applications::class, "create"])->name("create")->middleware("can:create");
            Route::post("/{application}", [Applications::class, "edit"])->name("edit")->middleware("can:edit,application");
            Route::delete("/{application}", [Applications::class, "delete"])->name("delete")->middleware("can:delete,application");
            Route::post("/{application}/refresh-token", [Applications::class, "refreshToken"])->name("refreshToken")->middleware("can:edit,application");
        });
        Route::name("redirect_urls")->prefix("/redirect-urls")->middleware("hasPermission:applications")->group(function () {
            Route::get("/", [RedirectUrls::class, "index"])->name("index");
            Route::post("/", [RedirectUrls::class, "create"])->name("create")->middleware("can:create");
            Route::post("/{redirect_url}", [RedirectUrls::class, "edit"])->name("edit")->middleware("can:edit,redirect_url");
            Route::delete("/{redirect_url}", [RedirectUrls::class, "delete"])->name("delete")->middleware("can:delete,redirect_url");
        });
        Route::name("valid_domains")->prefix("/valid-domains")->middleware("hasPermission:applications")->group(function () {
            Route::get("/", [ValidDomains::class, "index"])->name("index");
            Route::post("/", [ValidDomains::class, "create"])->name("create")->middleware("can:create");
            Route::post("/{valid_domain}", [ValidDomains::class, "edit"])->name("edit")->middleware("can:edit,valid_domain");
            Route::delete("/{valid_domain}", [ValidDomains::class, "delete"])->name("delete")->middleware("can:delete,valid_domain");
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
