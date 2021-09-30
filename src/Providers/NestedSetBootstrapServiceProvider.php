<?php

namespace Fawest\Providers\Nestedset;

use Fawest\Nestedset\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class NestedSetBootstrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateCategoriesTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__ . '/../../database/migrations/create_categories_table.php.stub' => database_path('migrations/'.$timestamp.'_create_categories_table.php'),
                ], 'fawest-categorize-migrations');
            }
        }
    }
}
