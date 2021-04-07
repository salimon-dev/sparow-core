<?php

namespace App\Providers;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend("hasAccessToApplication", function ($attribute, $value, $parameters, $validator) {
            if (!Auth::check()) {
                return false;
            }
            $user = Auth::user();
            if (!$user->hasPermission("applications")) {
                return false;
            }
            $application = Application::where("id", $value)->first();
            if (!$application) {
                return false;
            }
            if ($application->user_id != $user->id) {
                return false;
            }
            return true;
        }, "you don't have access to this application");
    }
}
