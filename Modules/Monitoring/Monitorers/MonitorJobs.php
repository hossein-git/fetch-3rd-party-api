<?php

namespace Modules\Monitoring\Monitorers;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class MonitorJobs
{
    static function monitorBeforeRun()
    {
        Queue::before(function (JobProcessing $event) {
            $info = self::makeView($event);
            Log::channel(self::logDriver())->info($info);
        });
    }

    static function monitorAfterRun()
    {
        Queue::after(function (JobProcessed $event) {
            $info = self::makeView($event);
            Log::channel(self::logDriver())->info($info);
        });
    }

    protected static function makeView($event)
    {
        $job = $event->job;
        return view('monitoring::sample-jobs')
            ->with(
                [
                    'connection' => $event->connectionName,
                    'job' => $job->resolveName(),
                    'status' => $job->hasFailed() ? 'Failed' : 'success',
                ]
            )
            ->render();
    }

    protected static function logDriver()
    {
        return config('monitoring.log_jobs_diver');
    }
}
