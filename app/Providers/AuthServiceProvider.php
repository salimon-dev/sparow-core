<?php

namespace App\Providers;

use App\Models\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Passport\AuthCode;
use App\Models\Passport\Client;
use App\Models\Passport\PersonalAccessClient;
use App\Models\Passport\Token;
use App\Models\RedirectUrl;
use App\Models\ValidDomain;
use App\Policies\ApplicationPolicy;
use App\Policies\RedirectUrlPolicy;
use App\Policies\ValidDomainPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Application::class => ApplicationPolicy::class,
        RedirectUrl::class => RedirectUrlPolicy::class,
        ValidDomain::class => ValidDomainPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::useTokenModel(Token::class);
        Passport::useClientModel(Client::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

        Passport::tokensCan([
            "info" => "info",
            "payment" => "payment",
            "applications" => "applications",
            "permissions" => "permissions",
        ]);

        Passport::setDefaultScope([
            "info" => "info"
        ]);
    }
}
