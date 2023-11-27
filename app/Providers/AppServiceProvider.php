<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


        // Persistence


        // Infrastructure
        $this->app->bind(
            \App\Core\Interfaces\Services\IMailService::class,
            \App\Infrastructure\Services\MailService::class
        );

        // Common
        $this->app->bind(
            \App\Common\Date\IDateService::class,
            \App\Common\Date\DateService::class
        );


        //other

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::authenticateAccessTokensUsing(function (PersonalAccessToken $token, $isValid) {
            if($isValid) return true;
            return $token->can('remember') && $token->created_at->gt(now()->subYears(1));
        });
    }
}
