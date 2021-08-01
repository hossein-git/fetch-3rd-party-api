<?php


namespace Modules\Address\Repositories;


use Modules\Address\Models\BillingAddress;
use Modules\Address\Models\ShippingAddress;
use Modules\Base\Repositories\BaseRepository;


class ShippingAddressRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = ShippingAddress::class;

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
        return ShippingAddress::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
