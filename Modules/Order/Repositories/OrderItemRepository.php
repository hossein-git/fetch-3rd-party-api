<?php


namespace Modules\Order\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Order\Models\OrderItem;


class OrderItemRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = OrderItem::class;

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
        return OrderItem::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
