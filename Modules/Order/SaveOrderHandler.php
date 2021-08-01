<?php

namespace Modules\Order;


use Modules\Address\Jobs\SaveAddressJob;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Jobs\RemoveApiCachesJob;
use Modules\Customer\Jobs\SaveCustomerJob;
use Modules\Order\Jobs\ChangeOrderStatusJob;
use Modules\Order\Jobs\GetOrderDetailsJob;
use Modules\Order\Jobs\SaveItemsOrderJob;
use Modules\Order\Jobs\SaveOrderJob;
use Modules\Order\Jobs\SaveSingleOrderItemJob;
use Modules\Product\Jobs\SaveProductJob;

class SaveOrderHandler
{
    public static function saveDetails()
    {
        $orders = CacheApiFacade::getCachedOrderList() ?? [];
        $countOrders = count($orders);
        foreach ($orders as $key => $order) {
            SaveOrderJob::dispatch($order);
            $orderId = $order['id'];
            //get order details before start
            GetOrderDetailsJob::dispatch($orderId)->delay(now()->addSeconds($key + 1));
            SaveCustomerJob::dispatch($orderId)->delay(now()->addSeconds($key + 2));
            SaveAddressJob::dispatch($orderId)->delay(now()->addSeconds($key + 2));
            //save order items products
            SaveItemsOrderJob::dispatch($orderId)->delay(now()->addSeconds($key + 3));
            //change status
            ChangeOrderStatusJob::dispatch($orderId)->delay(now()->addSeconds($key + 4));
            //remove this loop cache key
            RemoveApiCachesJob::dispatch($orderId)->delay(now()->addSeconds($key + 5));
            if (($key + 1) === $countOrders) {
                //remove order list cache
                CacheApiFacade::removeCachedOrderList();

                //go to next page by increase the relative cache
                CacheApiFacade::goNextPage();
            }
        }
    }

    public static function saveOrderItems(int $order_id)
    {
        $details = CacheApiFacade::readCachedDetails($order_id);
        if ($details && isset($details['order_items'])) {
            foreach ($details['order_items'] as $orderItem) {
                SaveSingleOrderItemJob::dispatch($orderItem);
                SaveProductJob::dispatch($orderItem['product']);
            }
        }
    }
}
