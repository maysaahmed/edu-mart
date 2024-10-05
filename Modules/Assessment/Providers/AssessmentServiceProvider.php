<?php

namespace Modules\Assessment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class AssessmentServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Assessment';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'assessment';

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
            \Modules\Assessment\Core\Option\Queries\GetOptions\IGetOptions::class,
            \Modules\Assessment\Core\Option\Queries\GetOptions\GetOptions::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Option\Repositories\IOptionRepository::class,
            \Modules\Assessment\Infrastructure\Option\OptionRepository::class
        );

        //questions
        $this->app->bind(
            \Modules\Assessment\Core\Question\Queries\GetQuestionPagination\IGetQuestionPagination::class,
            \Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPagination::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Question\Queries\GetQuestions\IGetQuestions::class,
            \Modules\Assessment\Core\Question\Queries\GetQuestions\GetQuestions::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Question\Commands\EditQuestion\IEditQuestion::class,
            \Modules\Assessment\Core\Question\Commands\EditQuestion\EditQuestion::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Question\Commands\ReorderQuestions\IReorderQuestions::class,
            \Modules\Assessment\Core\Question\Commands\ReorderQuestions\ReorderQuestions::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Question\Repositories\IQuestionRepository::class,
            \Modules\Assessment\Infrastructure\Question\QuestionRepository::class
        );

        //factors

        $this->app->bind(
            \Modules\Assessment\Core\Factor\Queries\GetFactors\IGetFactors::class,
            \Modules\Assessment\Core\Factor\Queries\GetFactors\GetFactors::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Factor\Commands\EditFactor\IEditFactor::class,
            \Modules\Assessment\Core\Factor\Commands\EditFactor\EditFactor::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Factor\Repositories\IFactorRepository::class,
            \Modules\Assessment\Infrastructure\Factor\FactorRepository::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Result\Commands\CreateResult\ICreateResult::class,
            \Modules\Assessment\Core\Result\Commands\CreateResult\CreateResult::class
        );

        $this->app->bind(
            \Modules\Assessment\Core\Result\Repositories\IResultRepository::class,
            \Modules\Assessment\Infrastructure\Result\ResultRepository::class
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
