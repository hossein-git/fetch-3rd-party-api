<?php


namespace Modules\Company\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Company\Models\Company;


class CompanyRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = Company::class;

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
        return Company::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
