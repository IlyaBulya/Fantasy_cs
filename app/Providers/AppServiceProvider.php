<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Steam\Provider as SteamProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Регистрация драйвера Steam для Socialite
        Socialite::extend('steam', function ($app) {
            $config = $app['config']['services.steam'];

            return Socialite::buildProvider(
                SteamProvider::class,
                $config
            );
        });
    }
}
