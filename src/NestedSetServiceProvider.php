<?php

namespace Fawest\Nestedset;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class NestedSetServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        php artisan vendor:publish --provider="Fawest\Nestedset\NestedSetServiceProvider" --tag="migrations"
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateCategoriesTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_categories_table.php.stub' => database_path('migrations/'.$timestamp.'_create_categories_table.php'),
                ], 'migrations');
            }
        }
    }
    public function register()
    {
        Blueprint::macro('nestedSet', function () {
            NestedSet::columns($this);
        });

        Blueprint::macro('dropNestedSet', function () {
            NestedSet::dropColumns($this);
        });
    }
}
