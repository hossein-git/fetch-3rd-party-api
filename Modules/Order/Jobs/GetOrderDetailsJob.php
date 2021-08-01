<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;

/**
 * this class will fire a request: APIFacade::getOrderDetails ,
 * to get order details and save it into cache
 */
class GetOrderDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $order_id;

    public $tries = 10;

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }

    public function handle()
    {
        $orderId = $this->order_id;
        $details = APIFacade::getOrderDetails($orderId);
        CacheApiFacade::cacheOrderDetails($details, $orderId);
    }
}
