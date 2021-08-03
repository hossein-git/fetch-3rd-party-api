<?php

namespace Modules\API\Services;


use Modules\API\Facades\HttpFacade;
use Modules\Monitoring\Facades\MonitoringFacade;

class APIService
{

    public function getLastPage(?int $id = null)
    {
        return $this->getLastPageFromDb($id);
    }

    private function getLastPageFromDb(?int $id = null)
    {
        $list = $this->getOrderList($id);
        if (!isset($list['last_page'])) {
            throw new \Exception("Error to get list ");
        }
        return $list['last_page'];
    }

    public function getOrderList(int $id = null, int $page = null)
    {
        $params = [
            'id' => $id,
            'page' => $page,
        ];
        $response = HttpFacade::getRequest(config('api_config.get_orders_endpoint'), $params);
        if (!$response->successful()) {
            $error = 'Response Is not Successful '.$response->status().' '.$response->serverError();
            throw new \Exception($error);
        }

        return json_decode($response->body(), true);
    }

    public function getOrderDetails(int $id)
    {
        $response = HttpFacade::getRequest(config('api_config.get_order_details_endpoint').$id);
        return json_decode($response->body(), true);
    }

    public function changeOrderStatus(int $order_id, array $params)
    {
        return HttpFacade::postRequest(config('api_config.change_order_status_endpoint').$order_id, $params);
    }


}
