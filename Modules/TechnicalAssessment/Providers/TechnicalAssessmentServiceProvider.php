<?php

namespace Modules\TechnicalAssessment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class TechnicalAssessmentServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'TechnicalAssessment';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'technicalassessment';

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
            \Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\ICreateAssessment::class,
            \Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment\CreateAssessment::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\IEditAssessment::class,
            \Modules\TechnicalAssessment\Core\Assessment\Commands\EditAssessment\EditAssessment::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment\IDeleteAssessment::class,
            \Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment\DeleteAssessment::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode\ICheckAssessmentCode::class,
            \Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode\CheckAssessmentCode::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment\IGetAssessment::class,
            \Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment\GetAssessment::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments\IGetAssessments::class,
            \Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments\GetAssessments::class
        );


        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\ICreateAssessmentQuestion::class,
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\CreateAssessmentQuestion\CreateAssessmentQuestion::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion\IEditAssessmentQuestion::class,
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\EditAssessmentQuestion\EditAssessmentQuestion::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\DeleteAssessmentQuestion\IDeleteAssessmentQuestion::class,
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Commands\DeleteAssessmentQuestion\DeleteAssessmentQuestion::class
        );


        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization\IAssignAssessmentToOrganization::class,
            \Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization\AssignAssessmentToOrganization::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization\IUnassignAssessmentFromOrganization::class,
            \Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization\UnassignAssessmentFromOrganization::class
        );


        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier\ICreateAssessmentTier::class,
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier\CreateAssessmentTier::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier\IEditAssessmentTier::class,
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\EditAssessmentTier\EditAssessmentTier::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\DeleteAssessmentTier\IDeleteAssessmentTier::class,
            \Modules\TechnicalAssessment\Core\AssessmentTier\Commands\DeleteAssessmentTier\DeleteAssessmentTier::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\IPostAssessmentAnswer::class,
            \Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer\PostAssessmentAnswer::class
        );

        // Persistence
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository::class,
            \Modules\TechnicalAssessment\Infrastructure\Assessment\AssessmentRepository::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository::class,
            \Modules\TechnicalAssessment\Infrastructure\AssessmentQuestion\AssessmentQuestionRepository::class
        );
        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories\IAssessmentOrganizationRepository::class,
            \Modules\TechnicalAssessment\Infrastructure\AssessmentOrganization\AssessmentOrganizationRepository::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentTier\Repositories\IAssessmentTierRepository::class,
            \Modules\TechnicalAssessment\Infrastructure\AssessmentTier\AssessmentTierRepository::class
        );

        $this->app->bind(
            \Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository::class,
            \Modules\TechnicalAssessment\Infrastructure\AssessmentAnswer\AssessmentAnswerRepository::class
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
