<?php

namespace Modules\Product\Services;


use Modules\Product\Repositories\ProductRepository;

class ProductService
{

    /**
     * @var ProductRepository
     */
    private $repo;

    public function __construct()
    {
        $this->repo = resolve(ProductRepository::class);
    }

    public function create(array $input)
    {
        return $this->repo->create($input);
    }


}
