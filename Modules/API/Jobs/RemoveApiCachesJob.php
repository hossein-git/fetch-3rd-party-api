<?php

namespace Modules\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;
use Modules\Order\Facades\OrderFacade;


class RemoveApiCachesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * @var int
     */
    private $order_id;

    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }


    public function handle()
    {
        //remove this order details cache
        CacheApiFacade::removeCacheOrderDetails($this->order_id);
    }

}
