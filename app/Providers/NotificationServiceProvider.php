<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NotificationService;
class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationService::class, function ($app) {
            return new NotificationService(config('notification_client'));
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