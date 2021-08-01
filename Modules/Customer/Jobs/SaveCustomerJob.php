<?php

namespace Modules\Customer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\CacheApiFacade;
use Modules\Customer\Facades\CustomerFacade;

class SaveCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var int
     */
    private $order_id;

    public function __construct($order_id = null)
    {
        $this->order_id = $order_id;
    }

    public function handle()
    {
        $customer = CacheApiFacade::getCustomer($this->order_id);
        if ($customer)
            CustomerFacade::create($customer);
    }

}
