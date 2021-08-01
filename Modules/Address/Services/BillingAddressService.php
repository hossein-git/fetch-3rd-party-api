<?php

namespace Modules\Address\Services;


use Modules\Address\Repositories\BillingAddressRepository;

class BillingAddressService
{

    /**
     * @var BillingAddressRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(BillingAddressRepository::class);
    }

    public function create(array $input)
    {
        return $this->repo->create($input);
    }


}
