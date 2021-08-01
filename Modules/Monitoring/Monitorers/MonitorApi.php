<?php

namespace Modules\Monitoring\Monitorers;



use Modules\Monitoring\Monitorer;

class MonitorApi extends Monitorer
{

    public function monitorApiService()
    {
        //these methods run before fire in APIFacade
        $this->monitorLastPage();
        $this->monitorOrderList();
        $this->monitorOrderDetails();
        $this->monitorChangeStatus();
    }

    private function monitorLastPage(): void
    {
        $this->getPreCall('getLastPage');
        $this->getPostCall('getLastPage');
    }

    private function monitorOrderList()
    {
        $this->getPreCall('getOrderList');
        $this->getPostCall('getOrderList');
    }

    private function monitorOrderDetails()
    {
        $this->getPreCall('getOrderDetails');
        $this->getPostCall('getOrderDetails');
    }

    private function monitorChangeStatus()
    {
        $this->getPreCall('changeOrderStatus');
        $this->getPostCall('changeOrderStatus');
    }
}
