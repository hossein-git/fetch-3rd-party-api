<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\APIFacade;
use Modules\Order\Facades\OrderFacade;
use Modules\Order\Models\Order;

class ChangeOrderStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 4;
    public $tries = 5;

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
        $orderId = $this->order_id;
        $params = ['type' => Order::APPROVED_STATUS];

        APIFacade::changeOrderStatus($orderId, $params);
        OrderFacade::update($orderId,$params);
    }

}
