<?php

namespace Modules\Monitoring;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\API\Facades\APIFacade;
use Modules\Monitoring\Monitorers\MonitorApi;
use Modules\Monitoring\Monitorers\MonitorJobs;


class MonitoringServiceProvider extends ServiceProvider
{

    public function register()
    {
        try {
            (new MonitorApi(new APIFacade()))->monitorApiService();
        } catch (\Exception $exception) {
            Log::error('monitoring API Error'.$exception->getMessage());
        }
    }

    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/monitoring_config.php',
            'monitoring'
        );

        $this->loadViewsFrom(__DIR__.'/views', 'monitoring');

        MonitorJobs::monitorBeforeRun();
        MonitorJobs::monitorAfterRun();
    }

}
