<?php

namespace Modules\API\Jobs;

use Illuminate\Bus\Queueable;
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
class GetOrderListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $page;

    public function __construct(int $id = null, int $page = null)
    {
        $this->id = $id;
        $this->page = $page;
    }

    public function handle()
    {
        $latestId = $this->id ?? CacheApiFacade::getCachedLatestId();
        $lastPage = $this->page ?? CacheApiFacade::getLastOrdersPage();

        //get the orders in last page
        $orders = APIFacade::getOrderList($latestId, $lastPage);

        //put order list into cache
        CacheApiFacade::cacheOrderList($orders['data']);
    }

}
