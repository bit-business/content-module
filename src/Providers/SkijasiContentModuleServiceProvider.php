<?php

namespace NadzorServera\Skijasi\Module\Content\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use NadzorServera\Skijasi\Module\Content\SkijasiContentModule;
use NadzorServera\Skijasi\Module\Content\Commands\SkijasiContentSetup;
use NadzorServera\Skijasi\Module\Content\Commands\SkijasiContentTestSetup;
use NadzorServera\Skijasi\Module\Content\Facades\SkijasiContentModule as FacadesSkijasiContentModule;

class SkijasiContentModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('SkijasiContentModule', FacadesSkijasiContentModule::class);

        $this->app->singleton('skijasi-content-module', function () {
            return new SkijasiContentModule();
        });

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'skijasi-content');

        $this->publishes([
            __DIR__.'/../Config/skijasi-content.php' => config_path('skijasi-content.php'),
            __DIR__.'/../Swagger' => app_path('Http/Swagger/swagger_models'),
            __DIR__.'/../Seeder' => database_path('seeders/Skijasi/Content'),
        ], 'skijasi-content-module');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommands();
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(SkijasiContentSetup::class);
        $this->commands(SkijasiContentTestSetup::class);
    }
}
