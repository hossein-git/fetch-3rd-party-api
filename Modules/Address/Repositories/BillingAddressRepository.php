<?php


namespace Modules\Address\Repositories;


use Modules\Address\Models\BillingAddress;
use Modules\Base\Repositories\BaseRepository;


class BillingAddressRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = BillingAddress::class;

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
        return BillingAddress::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
