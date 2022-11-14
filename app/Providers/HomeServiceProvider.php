<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repo\HomeService;
class HomeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HomeService', function($app) {
            return new homeService();
        });
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
