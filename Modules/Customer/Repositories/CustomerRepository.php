<?php


namespace Modules\Customer\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Customer\Models\Customer;


class CustomerRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = Customer::class;

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
        return Customer::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
