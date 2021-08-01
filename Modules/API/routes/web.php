<?php


use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\Address\Facades\BillingAddressFacade;
use Modules\Address\Facades\ShippingAddressFacade;
use Modules\Address\Jobs\SaveAddressJob;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Jobs\GetLastOrdersPageJob;
use Modules\API\Jobs\GetOrderListJob;
use Modules\Customer\Facades\CustomerFacade;
use Modules\Customer\Jobs\SaveCustomerJob;
use Modules\Order\Facades\OrderFacade;
use Modules\Order\Facades\OrderItemFacade;
use Modules\Order\Jobs\ChangeOrderStatusJob;
use Modules\Order\Jobs\GetOrderDetailsJob;
use Modules\Order\Jobs\HandleSaveOrderDetailsJob;
use Modules\Order\Jobs\SaveOrderJob;
use Modules\Order\SaveOrderHandler;
use Modules\Product\Facades\ProductFacade;
use Modules\Product\Jobs\SaveProductJob;


Route::get('/test5', function () {
    //get latest page and latest id to start fetching
    GetLastOrdersPageJob::dispatch()->onConnection('sync');
    // get orders bigger than ID which are in last page
    GetOrderListJob::dispatch()->delay(now()->addSeconds(5));

//    while ((int)$latestPage !== 1) {
//
//        //TODO delete details cache
//        //go to next page
//        $latestPage--;
//        GetOrderListJob::dispatch(null, $latestPage);
//    }

});

Route::get('/test4', function () {

});


Route::get('/test3', function () {

    $latestId = OrderFacade::getLatestRowId();
    $lastPage = APIFacade::getLastPage($latestId);
    $orders = APIFacade::getOrderList($latestId, $lastPage);
    //put order list into cache
    $orders = $orders['data'];
    while ((int)$lastPage !== 1) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($orders as $order) {
            $orderId = $order['id'];
            $details = APIFacade::getOrderDetails($orderId);
            if (isset($details['customer'])){
                CustomerFacade::create($details['customer']);
            }
            if (isset($details['billing_address'])){
                BillingAddressFacade::create($details['billing_address']);
            }
            if (isset($details['shipping_address'])){
                ShippingAddressFacade::create($details['shipping_address']);
            }

            OrderFacade::saveOrder($order);

            //save order items products
            if (isset($details['order_items'])){
                foreach ($details['order_items'] as $orderItem) {
                    OrderItemFacade::saveOrderItem($orderItem);
                    ProductFacade::create($orderItem['product']);
                }
            }

            //change status
            ChangeOrderStatusJob::dispatch($orderId);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //go to next page
        $lastPage --;
        $latestId = OrderFacade::getLatestRowId();
        $orderList = APIFacade::getOrderList($latestId, $lastPage);
        $orders = $orderList['data'];
//        GetOrderListJob::dispatch(null, $lastPage);
    }
});

Route::get('/test2', function () {
    Bus::chain(
        [
            //save last page into cache
            new GetLastOrdersPageJob(),
            //get orders according the latest id and last page and put it into cache
            new GetOrderListJob(),
        ]
    )->onConnection('redis')
        ->dispatch();
    $orders = CacheApiFacade::getCachedOrderList();
    $lastPage = CacheApiFacade::getLastOrdersPage();

    while ((int)$lastPage !== 1) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($orders as $order) {
            $orderId = $order['id'];
            //get order details before start
            $details = APIFacade::getOrderDetails($orderId);

            if (isset($details['customer']))
                SaveCustomerJob::dispatch($details['customer']);


            if (isset($details['shipping_address']))
                if (isset($details['shipping_address']))
                    SaveAddressJob::dispatch($details);

            SaveOrderJob::dispatch($order);

            //save order items products
            if (isset($details['order_items']))
                foreach ($details['order_items'] as $orderItem)
//                    OrderItemFacade::saveOrderItem($orderItem);
                    SaveOrderItemsJob::dispatch($orderItem);
                    SaveProductJob::dispatch($orderItem['product']);


            //change status
            ChangeOrderStatusJob::dispatch($orderId);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //go to next page
        $lastPage --;
        $latestId = OrderFacade::getLatestRowId();
        GetOrderListJob::dispatch($latestId, $lastPage);
        $orderList = CacheApiFacade::getCachedOrderList();
        if (isset($orderList['data'])){
            $orders = $orderList['data'];
        }
//        GetOrderListJob::dispatch(null, $lastPage);
    }
});


Route::get('/test', function () {
    GetLastOrdersPageJob::dispatch();
    GetOrderListJob::dispatch()->delay(now()->addSeconds(5));
    $latestId = CacheApiFacade::getCachedLatestId();
    $latestPage = CacheApiFacade::getLastOrdersPage();
    $orders = CacheApiFacade::getCachedOrderList();
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    while ((int)$latestPage !== 1) {
        foreach ($orders as $order) {
            $orderId = $order['id'];
            //get order details before start
            GetOrderDetailsJob::dispatch($orderId);
            //save order
            SaveOrderJob::dispatch($order);
            // save order details
            Bus::chain(
                [
//                    new GetOrderDetailsJob($orderId),
                    new SaveOrderItemsJob($orderId),
                    new SaveCustomerJob($orderId),
                    new SaveAddressJob($orderId),
                ]
            )->onConnection('redis')
                ->dispatch();
            dd(CacheApiFacade::readCachedDetails($orderId));
            //save order items products
            foreach ($order['order_items'] as $product) {
                SaveProductJob::dispatch($product);
            }
            //change status
            ChangeOrderStatusJob::dispatch($orderId);
        }
        //TODO delete details cache
        //go to next page
        $latestPage--;
        GetOrderListJob::dispatch(null, $latestPage);
    }
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
});

