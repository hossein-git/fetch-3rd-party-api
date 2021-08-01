<?php

namespace Modules\Order\Services;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Repositories\OrderRepository;

class OrderItemService
{

    /**
     * @var OrderItemRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(OrderItemRepository::class);
    }

    public function saveOrderItem(array $details)
    {
        if ($details['order_id']){
            return $this->repo->create($details);
        }
    }

}
