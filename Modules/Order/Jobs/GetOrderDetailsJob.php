<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Cache\RateLimiting\GlobalLimit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 4;


    public function setDelay(int $delay): void
    {
        $this->delay = 4;
    }

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }

//    public function middleware()
//    {
//        return [(new ThrottlesExceptions(10, 1))->backoff(5)];
//    }

    public function handle()
    {
        $orderId = $this->order_id;
        $details = APIFacade::getOrderDetails($orderId);
        CacheApiFacade::cacheOrderDetails($details, $orderId);
    }
}
