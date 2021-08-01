<?php

namespace Modules\Product;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Facades\ProductFacade;
use Modules\Product\Services\ProductService;


class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        ProductFacade::shouldProxyTo(ProductService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
