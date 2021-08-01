<?php

namespace Modules\Monitoring;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Monitoring\Facades\MonitoringFacade;
use Modules\Monitoring\Services\MonitoringService;


class MonitoringServiceProvider extends ServiceProvider
{
    private $namespace = 'Modules\Monitoring\Http\Controllers';

    public function register()
    {
        MonitoringFacade::shouldProxyTo(MonitoringService::class);
        //add mocking in tests
//        if (app()->runningUnitTests()) {
//        } else {
//        }
    }

    public function boot()
    {
//        $this->mergeConfigFrom(
//            __DIR__.'/config/monitoring_config.php',
//            'monitoring_config'
//        );
        if (!$this->app->routesAreCached()) {
            //$this->mapApiRoutes();
            //since we dont have web routes we dont load it
//            $this->mapWebRoutes();
        }

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    private function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/api.php');
    }

    private function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/web.php');
    }
}
