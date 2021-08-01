<?php

namespace Modules\Order\Services;


use Modules\Order\Repositories\OrderRepository;

class OrderService
{

    /**
     * @var OrderRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(OrderRepository::class);
    }

    public function saveOrder(array $order)
    {
        return $this->repo->create($order);
    }

    public function update($id,$params)
    {
        return $this->repo->update($params, $id);
    }

    public function getLatestRowId()
    {
        return $this->repo->makeModel()->latest()->first(['id'])->id ?? 1;
    }


}
