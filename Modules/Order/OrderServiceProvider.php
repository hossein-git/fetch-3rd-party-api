<?php

namespace Modules\Order;

use Illuminate\Support\ServiceProvider;
use Modules\Order\Facades\OrderFacade;
use Modules\Order\Facades\OrderItemFacade;
use Modules\Order\Services\OrderItemService;
use Modules\Order\Services\OrderService;


class OrderServiceProvider extends ServiceProvider
{

    public function register()
    {
        OrderFacade::shouldProxyTo(OrderService::class);
        OrderItemFacade::shouldProxyTo(OrderItemService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
