<?php

namespace Modules\Customer\Services;


use Modules\Customer\Repositories\CustomerRepository;

class CustomerService
{

    /**
     * @var CustomerRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(CustomerRepository::class);
    }


    public function create(array $input)
    {
        if (!$input['email']){
            $input['email'] =$input['id'].'nomail@sxxx.co';
        }
        if (!$input['name']){
            $input['name'] =$input['id'].'noName';
        }
        return $this->repo->create($input);
    }


}
