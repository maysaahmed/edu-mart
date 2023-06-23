<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


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
        //
    }
}
