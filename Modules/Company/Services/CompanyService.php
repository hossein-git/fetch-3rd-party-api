<?php

namespace Modules\Company\Services;


use Modules\Company\Repositories\CompanyRepository;

class CompanyService
{

    /**
     * @var CompanyRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(CompanyRepository::class);
    }


}
