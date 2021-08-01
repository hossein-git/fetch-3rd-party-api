<?php

namespace Modules\Customer;

use Illuminate\Support\ServiceProvider;
use Modules\Customer\Facades\CustomerFacade;
use Modules\Customer\Services\CustomerService;

class CustomerServiceProvider extends ServiceProvider
{

    public function register()
    {
        CustomerFacade::shouldProxyTo(CustomerService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

}
