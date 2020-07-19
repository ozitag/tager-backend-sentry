<?php

namespace OZiTAG\Tager\Backend\Sentry;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class TagerBackendSentryServiceProvider extends RouteServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('tager-sentry.php'),
        ]);

        parent::boot();
    }
}
