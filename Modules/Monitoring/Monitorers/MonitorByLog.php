<?php

namespace Modules\Monitoring\Monitorers;


use Illuminate\Support\Facades\Log;

class MonitorByLog
{

    private $channel;

    public function __construct()
    {
        $this->channel = config('monitoring.log_jobs_diver');
    }

    public function log(string $log, string $type = 'info')
    {
        return Log::channel($this->channel)->$type($log);
    }
}
