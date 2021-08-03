<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Address\Jobs\SaveAddressJob;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Http\Controllers\SendApiController;
use Modules\API\Jobs\RemoveApiCachesJob;
use Modules\Customer\Jobs\SaveCustomerJob;

/**
 * this class will fire a request: APIFacade::getOrderDetails ,
 * to get order details and save it into cache
 */
class GetOrderDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 2;
    /**
     * @var int
     */
    private $order_id;

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }

    public function setDelay(int $delay): void
    {
        $this->delay = 2;
    }


    public function handle()
    {
        $orderId = $this->order_id;
        try {
            $details = resolve(SendApiController::class)->getOrderDetails($orderId);
        } catch (\Exception $exception) {
            $this->release(now()->addMinutes(1));
            $this->fail($exception->getMessage());
            return;
        }
        CacheApiFacade::cacheOrderDetails($details, $orderId);
    }

    /**
     * if this job failed then those job below can not fetch data
     * so in case of failed they will be in queue with relative order Id
     */
    public function fail()
    {
        $orderId = $this->order_id;
        SaveCustomerJob::dispatch($orderId)->delay(now()->addMinutes(2));
        SaveAddressJob::dispatch($orderId)->delay(now()->addMinutes(2));
        //save order items products
        SaveItemsOrderJob::dispatch($orderId)->delay(now()->addMinutes(2));
        //change status
        ChangeOrderStatusJob::dispatch($orderId)->delay(now()->addMinutes(3));
        //remove this loop cache key
        RemoveApiCachesJob::dispatch($orderId)->delay(now()->addMinutes(4));
    }
}
