<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthorizationService;
class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorizationService::class, function ($app) {
            return new AuthorizationService(config('authorizathion_client'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
