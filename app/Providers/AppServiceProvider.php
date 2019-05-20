<?php

namespace App\Providers;

use BeyondCode\DumpServer\DumpServerServiceProvider;
use Flipbox\LumenGenerator\LumenGeneratorServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env("APP_ENV") != "production"){
            $this->app->register(DumpServerServiceProvider::class);
            $this->app->register(LumenGeneratorServiceProvider::class);
        }
    }
}
