<?php

namespace Modules\Address\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Address\Facades\BillingAddressFacade;
use Modules\Address\Facades\ShippingAddressFacade;
use Modules\API\Facades\CacheApiFacade;

class SaveAddressJob implements ShouldQueue
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
        $orderId = $this->order_id;
        $billing_address = CacheApiFacade::getBillingAddress($orderId);
        $shipping_address = CacheApiFacade::getShippingAddress($orderId);
        if ($billing_address)
            BillingAddressFacade::create($billing_address);

        if ($shipping_address)
            ShippingAddressFacade::create($shipping_address);
    }

}
