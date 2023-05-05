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
        // Application/Core
        $this->app->bind(
            \App\Core\User\Commands\CreateUser\ICreateUser::class,
            \App\Core\User\Commands\CreateUser\CreateUser::class
        );
        $this->app->bind(
            \App\Core\User\Queries\GetUserPagination\IGetUserPagination::class,
            \App\Core\User\Queries\GetUserPagination\GetUserPagination::class
        );

        // Persistence
        $this->app->bind(
            \App\Core\User\Repositories\IUserRepository::class,
            \App\Infrastructure\User\UserRepository::class
        );

        // Infrastructure
//        $this->app->bind(
//            \App\Core\Interfaces\IImageOptimizeService::class,
//            \App\Infrastructure\ImageOptimize\ImageOptimizeService::class
//        );

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
