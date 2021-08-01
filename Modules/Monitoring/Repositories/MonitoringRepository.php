<?php


namespace Modules\Monitoring\Repositories;


use Modules\Base\Repositories\BaseRepository;
use Modules\Monitoring\Models\Monitoring;


class MonitoringRepository extends BaseRepository
{

    /**
     * @var string
     */
    protected $cacheKey = Monitoring::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

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
        return Monitoring::class;
    }


    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return $this->cacheKey;
    }

}
