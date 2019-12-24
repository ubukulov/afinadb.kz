<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BinotelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('binotel', 'App\Classes\Binotel');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
