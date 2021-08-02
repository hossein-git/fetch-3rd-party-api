<?php

namespace Modules\Monitoring;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\API\Facades\APIFacade;
use Modules\Monitoring\Facades\MonitoringFacade;
use Modules\Monitoring\Monitorers\MonitorApi;
use Modules\Monitoring\Monitorers\MonitorByLog;
use Modules\Monitoring\Monitorers\MonitorJobs;


class MonitoringServiceProvider extends ServiceProvider
{

    public function register()
    {
        MonitoringFacade::shouldProxyTo(MonitorByLog::class);
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
