<?php

namespace Fawest\Providers\Nestedset;

use Fawest\Nestedset\NestedSet;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class NestedSetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->app->register(NestedSetBootstrapServiceProvider::class);
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
