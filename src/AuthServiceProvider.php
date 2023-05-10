<?php

namespace Lugmety\Auth;

use Illuminate\Support\ServiceProvider;
use Lugmety\Auth\Services\Singleton\AppHeader;
use Lugmety\Auth\Services\Singleton\AuthUser;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . "/config/lugmety_auth.php", "lugmety_auth");
        $this->publishes([
            __DIR__ . "/config/lugmety_auth.php" => config_path("lugmety_auth.php")
        ]);
    }

    public function register()
    {
        $this->app->singleton(AppHeader::class, function ($app) {
            return new AppHeader();
        });

        $this->app->singleton(AuthUser::class, function ($app) {
            return new AuthUser();
        });
    }
}