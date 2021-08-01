<?php

namespace Modules\Address\Services;


use Modules\Address\Repositories\ShippingAddressRepository;

class ShippingAddressService
{

    /**
     * @var ShippingAddressRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(ShippingAddressRepository::class);
    }

    public function create(array $input)
    {
        return $this->repo->create($input);
    }


}
