<?php

namespace Modules\API\Http\Controllers;


use Exception;
use Illuminate\Support\Facades\Log;
use Modules\API\Facades\APIFacade;
use Modules\API\traits\ApiRateLimiter;
use Modules\Base\Http\Controllers\BaseController;

class SendApiController extends BaseController
{
    use ApiRateLimiter;

    public function __construct()
    {
        $this->initialLimiting();
    }

    public function getLastPage($id = null)
    {
        try {
            return APIFacade::getLastPage($id);
        } catch (Exception $exception) {
            return $this->handleException(\request(), $exception);
        }
    }


    public function getOrderList($id = null,$page = null)
    {
        try {
            return APIFacade::getOrderList($id,$page);
        } catch (Exception $exception) {
            return $this->handleException(\request(), $exception);
        }
    }

    public function getOrderDetails($id)
    {
        try {
            return APIFacade::getOrderDetails($id);
        } catch (Exception $exception) {
            return $this->handleException(\request(), $exception);
        }
    }

    public function changeOrderStatus($order_id,$params)
    {
        try {
            return APIFacade::changeOrderStatus($order_id, $params);
        } catch (Exception $exception) {
            return $this->handleException(\request(), $exception);
        }
    }
}
