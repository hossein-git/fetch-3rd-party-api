<?php


namespace Modules\Product\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Product\Models\Product;


class ProductRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = Product::class;

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
        return Product::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
