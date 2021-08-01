<?php

namespace Modules\Address;

use Illuminate\Support\ServiceProvider;
use Modules\Address\Facades\BillingAddressFacade;
use Modules\Address\Facades\ShippingAddressFacade;
use Modules\Address\Services\BillingAddressService;
use Modules\Address\Services\ShippingAddressService;


class AddressServiceProvider extends ServiceProvider
{

    public function register()
    {
        BillingAddressFacade::shouldProxyTo(BillingAddressService::class);
        ShippingAddressFacade::shouldProxyTo(ShippingAddressService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

}
