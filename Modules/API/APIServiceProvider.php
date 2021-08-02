<?php

namespace Modules\API;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\API\Console\StartGetOrdersCommand;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Facades\HttpFacade;
use Modules\API\Http\HttpRequest;
use Modules\API\Services\APIService;
use Modules\API\Services\CacheApiService;


class APIServiceProvider extends ServiceProvider
{
    private $namespace = 'Modules\API\Http\Controllers';

    public function register()
    {
        APIFacade::shouldProxyTo(APIService::class);
        HttpFacade::shouldProxyTo(HttpRequest::class);
        CacheApiFacade::shouldProxyTo(CacheApiService::class);
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config/api_config.php', 'api_config');
//        if (!$this->app->routesAreCached()) {
//            $this->mapWebRoutes();
//        }

        $this->commands(
            [StartGetOrdersCommand::class]
        );

        RateLimiter::for('fetch-order-list-middleware', function ($job) {
            return Limit::perMinute(30)->by($job);
        });
    }

    private function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/web.php');
    }
}
