<?php

namespace Modules\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Users';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'users';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(
            \Modules\Users\Core\User\Commands\CreateUser\ICreateUser::class,
            \Modules\Users\Core\User\Commands\CreateUser\CreateUser::class
        );

        $this->app->bind(
            \Modules\Users\Core\User\Commands\ImportUser\IImportUser::class,
            \Modules\Users\Core\User\Commands\ImportUser\ImportUser::class
        );

        $this->app->bind(
            \Modules\Users\Core\User\Commands\DeleteUser\IDeleteUser::class,
            \Modules\Users\Core\User\Commands\DeleteUser\DeleteUser::class
        );
        $this->app->bind(
            \Modules\Users\Core\User\Commands\EditUser\IEditUser::class,
            \Modules\Users\Core\User\Commands\EditUser\EditUser::class
        );

        $this->app->bind(
            \Modules\Users\Core\User\Commands\CompleteUserData\ICompleteUserData::class,
            \Modules\Users\Core\User\Commands\CompleteUserData\CompleteUserData::class
        );
        $this->app->bind(
            \Modules\Users\Core\User\Commands\VerifyUser\IVerifyUser::class,
            \Modules\Users\Core\User\Commands\VerifyUser\VerifyUser::class
        );
        $this->app->bind(
            \Modules\Users\Core\User\Commands\ResendMail\IResendMail::class,
            \Modules\Users\Core\User\Commands\ResendMail\ResendMail::class
        );
        $this->app->bind(
            \Modules\Users\Core\User\Queries\GetUserPagination\IGetUserPagination::class,
            \Modules\Users\Core\User\Queries\GetUserPagination\GetUserPagination::class
        );

        $this->app->bind(
            \Modules\Users\Core\Manager\Queries\GetOrganizationManagers\IGetOrganizationManagers::class,
            \Modules\Users\Core\Manager\Queries\GetOrganizationManagers\GetOrganizationManagers::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Queries\GetManagerPagination\IGetManagerPagination::class,
            \Modules\Users\Core\Manager\Queries\GetManagerPagination\GetManagerPagination::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\CreateManager\ICreateManager::class,
            \Modules\Users\Core\Manager\Commands\CreateManager\CreateManager::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\DeleteManager\IDeleteManager::class,
            \Modules\Users\Core\Manager\Commands\DeleteManager\DeleteManager::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\EditManager\IEditManager::class,
            \Modules\Users\Core\Manager\Commands\EditManager\EditManager::class
        );

        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\ImportManager\IImportManager::class,
            \Modules\Users\Core\Manager\Commands\ImportManager\ImportManager::class
        );

        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\EditManagerStatus\IEditManagerStatus::class,
            \Modules\Users\Core\Manager\Commands\EditManagerStatus\EditManagerStatus::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Commands\ResendMail\IResendMail::class,
            \Modules\Users\Core\Manager\Commands\ResendMail\ResendMail::class
        );
        $this->app->bind(
            \Modules\Users\Core\Auth\Commands\UserAuth\IUserAuth::class,
            \Modules\Users\Core\Auth\Commands\UserAuth\UserAuth::class
        );

        $this->app->bind(
            \Modules\Users\Core\User\Commands\ForgetPassword\IForgetPassword::class,
            \Modules\Users\Core\User\Commands\ForgetPassword\ForgetPassword::class
        );

        $this->app->bind(
            \Modules\Users\Core\User\Commands\ResetPassword\IResetPassword::class,
            \Modules\Users\Core\User\Commands\ResetPassword\ResetPassword::class
        );
        // Persistence
        $this->app->bind(
            \Modules\Users\Core\User\Repositories\IUserRepository::class,
            \Modules\Users\Infrastructure\User\UserRepository::class
        );
        $this->app->bind(
            \Modules\Users\Core\Manager\Repositories\IManagerRepository::class,
            \Modules\Users\Infrastructure\Manager\ManagerRepository::class
        );
        $this->app->bind(
            \Modules\Users\Core\Auth\Repositories\IAuthRepository::class,
            \Modules\Users\Infrastructure\Auth\AuthRepository::class
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
