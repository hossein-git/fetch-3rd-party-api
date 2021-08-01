<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Facades\OrderItemFacade;

class SaveSingleOrderItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $orderItem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $orderItem = null)
    {
        $this->orderItem = $orderItem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($orderItem = $this->orderItem)
            OrderItemFacade::saveOrderItem($orderItem);

    }
}
