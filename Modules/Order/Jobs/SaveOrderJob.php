<?php

namespace Modules\Order\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Facades\OrderFacade;

class SaveOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var array
     */
    private $order;

    public function __construct(array $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        OrderFacade::saveOrder($this->order);
    }

//    public function uniqueId()
//    {
//        return static::class . $this->order['id'];
//    }
}
