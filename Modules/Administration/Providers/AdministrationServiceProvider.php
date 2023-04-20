<?php

namespace Modules\Administration\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Administration\Core\Admin\Commands\AdminAuth\AdminAuth;
use Illuminate\Support\Facades\Facade;

class AdministrationServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Administration';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'administration';

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

        // Application/Core
        $this->app->bind(
            \Modules\Administration\Core\Admin\Queries\GetAdminPagination\IGetAdminPagination::class,
            \Modules\Administration\Core\Admin\Queries\GetAdminPagination\GetAdminPagination::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\CreateAdmin\ICreateAdmin::class,
            \Modules\Administration\Core\Admin\Commands\CreateAdmin\CreateAdmin::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\EditAdmin\IEditAdmin::class,
            \Modules\Administration\Core\Admin\Commands\EditAdmin\EditAdmin::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\DeleteAdmin\IDeleteAdmin::class,
            \Modules\Administration\Core\Admin\Commands\DeleteAdmin\DeleteAdmin::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\UpdateAdminStatus\IUpdateAdminStatus::class,
            \Modules\Administration\Core\Admin\Commands\UpdateAdminStatus\UpdateAdminStatus::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\EditProfile\IEditProfile::class,
            \Modules\Administration\Core\Admin\Commands\EditProfile\EditProfile::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\AdminAuth\IAdminAuth::class,
            \Modules\Administration\Core\Admin\Commands\AdminAuth\AdminAuth::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Admin\Commands\ChangePassword\IChangePassword::class,
            \Modules\Administration\Core\Admin\Commands\ChangePassword\ChangePassword::class
        );

        // Persistence
        $this->app->bind(
            \Modules\Administration\Core\Admin\Repositories\IAdminRepository::class,
            \Modules\Administration\Infrastructure\Admin\AdminRepository::class
        );

        $this->app->bind(
            \Modules\Administration\Core\Role\Repositories\IRoleRepository::class,
            \Modules\Administration\Infrastructure\Role\RoleRepository::class
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
