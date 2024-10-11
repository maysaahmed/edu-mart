<?php

namespace Modules\Courses\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class CoursesServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Courses';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'courses';

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
            \Modules\Courses\Core\Category\Commands\CreateCategory\ICreateCategory::class,
            \Modules\Courses\Core\Category\Commands\CreateCategory\CreateCategory::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Category\Commands\EditCategory\IEditCategory::class,
            \Modules\Courses\Core\Category\Commands\EditCategory\EditCategory::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Category\Commands\DeleteCategory\IDeleteCategory::class,
            \Modules\Courses\Core\Category\Commands\DeleteCategory\DeleteCategory::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Category\Commands\ImportCategory\IImportCategory::class,
            \Modules\Courses\Core\Category\Commands\ImportCategory\ImportCategory::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Category\Queries\GetCategoryPagination\IGetCategoryPagination::class,
            \Modules\Courses\Core\Category\Queries\GetCategoryPagination\GetCategoryPagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Category\Queries\GetCategories\IGetCategories::class,
            \Modules\Courses\Core\Category\Queries\GetCategories\GetCategories::class
        );

        //levels
        $this->app->bind(
            \Modules\Courses\Core\Level\Commands\CreateLevel\ICreateLevel::class,
            \Modules\Courses\Core\Level\Commands\CreateLevel\CreateLevel::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Level\Commands\EditLevel\IEditLevel::class,
            \Modules\Courses\Core\Level\Commands\EditLevel\EditLevel::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Level\Commands\DeleteLevel\IDeleteLevel::class,
            \Modules\Courses\Core\Level\Commands\DeleteLevel\DeleteLevel::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Level\Commands\ImportLevel\IImportLevel::class,
            \Modules\Courses\Core\Level\Commands\ImportLevel\ImportLevel::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Level\Queries\GetLevelPagination\IGetLevelPagination::class,
            \Modules\Courses\Core\Level\Queries\GetLevelPagination\GetLevelPagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Level\Queries\GetLevels\IGetLevels::class,
            \Modules\Courses\Core\Level\Queries\GetLevels\GetLevels::class
        );

        //providers
        $this->app->bind(
            \Modules\Courses\Core\Provider\Commands\CreateProvider\ICreateProvider::class,
            \Modules\Courses\Core\Provider\Commands\CreateProvider\CreateProvider::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Provider\Commands\EditProvider\IEditProvider::class,
            \Modules\Courses\Core\Provider\Commands\EditProvider\EditProvider::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Provider\Commands\DeleteProvider\IDeleteProvider::class,
            \Modules\Courses\Core\Provider\Commands\DeleteProvider\DeleteProvider::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Provider\Commands\ImportProvider\IImportProvider::class,
            \Modules\Courses\Core\Provider\Commands\ImportProvider\ImportProvider::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Provider\Queries\GetProviderPagination\IGetProviderPagination::class,
            \Modules\Courses\Core\Provider\Queries\GetProviderPagination\GetProviderPagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Provider\Queries\GetProviders\IGetProviders::class,
            \Modules\Courses\Core\Provider\Queries\GetProviders\GetProviders::class
        );
        //Courses
        $this->app->bind(
            \Modules\Courses\Core\Course\Commands\CreateCourse\ICreateCourse::class,
            \Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourse::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Course\Commands\EditCourse\IEditCourse::class,
            \Modules\Courses\Core\Course\Commands\EditCourse\EditCourse::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Course\Commands\DeleteCourse\IDeleteCourse::class,
            \Modules\Courses\Core\Course\Commands\DeleteCourse\DeleteCourse::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Course\Commands\DeleteCourse\IDeleteCourse::class,
            \Modules\Courses\Core\Course\Commands\DeleteCourse\DeleteCourse::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Commands\EditCourseVisibility\IEditCourseVisibility::class,
            \Modules\Courses\Core\Course\Commands\EditCourseVisibility\EditCourseVisibility::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetCoursePagination\IGetCoursePagination::class,
            \Modules\Courses\Core\Course\Queries\GetCoursePagination\GetCoursePagination::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination\IGetArchivedCoursePagination::class,
            \Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination\GetArchivedCoursePagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\IGetOrganizationCoursesPagination::class,
            \Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\GetOrganizationCoursesPagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetUserCoursesPagination\IGetUserCoursesPagination::class,
            \Modules\Courses\Core\Course\Queries\GetUserCoursesPagination\GetUserCoursesPagination::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetCourse\IGetCourse::class,
            \Modules\Courses\Core\Course\Queries\GetCourse\GetCourse::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice\IGetMinMaxCoursePrice::class,
            \Modules\Courses\Core\Course\Queries\GetMinMaxCoursePrice\GetMinMaxCoursePrice::class
        );

        //Requests
        $this->app->bind(
            \Modules\Courses\Core\Request\Commands\CreateRequest\ICreateRequest::class,
            \Modules\Courses\Core\Request\Commands\CreateRequest\CreateRequest::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Request\Commands\EditRequestStatus\IEditRequestStatus::class,
            \Modules\Courses\Core\Request\Commands\EditRequestStatus\EditRequestStatus::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Request\Commands\ManageRequest\IManageRequest::class,
            \Modules\Courses\Core\Request\Commands\ManageRequest\ManageRequest::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination\IGetOrganizationRequestsPagination::class,
            \Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination\GetOrganizationRequestsPagination::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination\IGetApprovedRequestsPagination::class,
            \Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination\GetApprovedRequestsPagination::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount\IGetOrganizationRequestsCount::class,
            \Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount\GetOrganizationRequestsCount::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Request\Queries\GetApprovedRequestsCount\IGetApprovedRequestsCount::class,
            \Modules\Courses\Core\Request\Queries\GetApprovedRequestsCount\GetApprovedRequestsCount::class
        );
        // Persistence
        $this->app->bind(
            \Modules\Courses\Core\Category\Repositories\ICategoryRepository::class,
            \Modules\Courses\Infrastructure\Category\CategoryRepository::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Level\Repositories\ILevelRepository::class,
            \Modules\Courses\Infrastructure\Level\LevelRepository::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Provider\Repositories\IProviderRepository::class,
            \Modules\Courses\Infrastructure\Provider\ProviderRepository::class
        );
        $this->app->bind(
            \Modules\Courses\Core\Course\Repositories\ICourseRepository::class,
            \Modules\Courses\Infrastructure\Course\CourseRepository::class
        );

        $this->app->bind(
            \Modules\Courses\Core\Request\Repositories\IRequestRepository::class,
            \Modules\Courses\Infrastructure\Request\RequestRepository::class
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
