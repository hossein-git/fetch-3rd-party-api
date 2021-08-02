<?php

namespace Modules\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;

/**
 * this class will fire a request: APIFacade::getOrderList ,
 * to get order list and save it into cache
 */
class GetOrderListJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    private $last_order_page;

    public function __construct($last_order_page)
    {
        $this->last_order_page = $last_order_page;
    }

    public function uniqueId()
    {
        return $this->last_order_page;
    }

    public function handle()
    {
        $latestId = CacheApiFacade::getCachedLatestId();
        $lastPage = $this->last_order_page;

        //get the orders in last page
        try {
            $orders = APIFacade::getOrderList($latestId, $lastPage);
        } catch (\Exception $exception) {
            $this->fail($exception->getMessage());
            return;
        }

        //put order list into cache
        CacheApiFacade::cacheOrderList($orders['data']);
    }

}
