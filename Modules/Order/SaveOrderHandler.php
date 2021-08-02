<?php

namespace Modules\Order;


use Modules\Address\Jobs\SaveAddressJob;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Jobs\RemoveApiCachesJob;
use Modules\Customer\Jobs\SaveCustomerJob;
use Modules\Order\Facades\OrderFacade;
use Modules\Order\Facades\OrderItemFacade;
use Modules\Order\Jobs\ChangeOrderStatusJob;
use Modules\Order\Jobs\GetOrderDetailsJob;
use Modules\Order\Jobs\SaveItemsOrderJob;
use Modules\Order\Jobs\SaveOrderJob;
use Modules\Order\Jobs\SaveSingleOrderItemJob;
use Modules\Product\Facades\ProductFacade;
use Modules\Product\Jobs\SaveProductJob;

class SaveOrderHandler
{
    public static function saveDetails()
    {
        $orders = CacheApiFacade::getCachedOrderList() ?? [];

        foreach ($orders as $key => $order) {
            try {
                OrderFacade::saveOrder($order);
            }catch (\Exception $exception){
                SaveOrderJob::dispatch($order);
            }
            $orderId = $order['id'];
            //get order details before start
            GetOrderDetailsJob::dispatch($orderId)->delay(now()->addSeconds($key));
            SaveCustomerJob::dispatch($orderId)->delay(now()->addSeconds($key + 2));
            SaveAddressJob::dispatch($orderId)->delay(now()->addSeconds($key + 2));
            //save order items products
            SaveItemsOrderJob::dispatch($orderId)->delay(now()->addSeconds($key + 2));
            //change status
            ChangeOrderStatusJob::dispatch($orderId)->delay(now()->addSeconds($key + 3));
            //remove this loop cache key
            RemoveApiCachesJob::dispatch($orderId)->delay(now()->addSeconds($key + 4));
        }
        //remove order list cache
        CacheApiFacade::removeCachedOrderList();
        //update last order_id in the cache
        CacheApiFacade::increaseLastId(count($orders));
    }

    public static function saveOrderItems(int $order_id)
    {
        $details = CacheApiFacade::readCachedDetails($order_id);
        if ($details && isset($details['order_items'])) {
            foreach ($details['order_items'] as $orderItem) {
                try {
                    OrderItemFacade::saveOrderItem($orderItem);
                }catch (\Exception $exception){
                    SaveSingleOrderItemJob::dispatch($orderItem);
                }
                $product = $orderItem['product'];
                try {
                    ProductFacade::create($product);
                }catch (\Exception $exception){
                    SaveProductJob::dispatch($product);
                }
            }
        }
    }
}
