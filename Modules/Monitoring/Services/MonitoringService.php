<?php

namespace Modules\Monitoring\Services;


use Modules\Monitoring\Repositories\MonitoringRepository;

class MonitoringService
{

    /**
     * @var MonitoringRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(MonitoringRepository::class);
    }


}
