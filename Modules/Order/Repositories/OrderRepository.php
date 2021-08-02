<?php


namespace Modules\Order\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Order\Models\Order;


class OrderRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = Order::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     */
    public function model(): string
    {
        return Order::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
