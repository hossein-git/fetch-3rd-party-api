<?php

namespace Modules\API\Console;

use Illuminate\Console\Command;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Jobs\GetOrderListJob;
use Modules\Order\Facades\OrderFacade;
use Modules\Order\SaveOrderHandler;


class StartGetOrdersCommand extends Command
{

    protected $signature = 'start-take-orders';

    protected $description = 'Start to take last page orders';

    public function handle()
    {
        //TODO: add visual command processor
        $latestPage = $this->processLatestPage();

        $this->processGetOrderList($latestPage);
        /**
         * it runs only when there is order list cache
         * 0 get order list from cache
         * 1 saves orders
         * 2 get order details
         * 3 save customer
         * 4 save addresses
         * 5 save order items
         * 6 change order status
         * 7 remove order list from cache
         * 8 last_id + count orders
         */
        SaveOrderHandler::saveDetails();
    }

    /**
     * take last current page from API according last order_id in local DB
     * and put the last_id into cache
     * in case of fails , it tries every 5 second
     */
    private function processLatestPage()
    {
        $crashed = 0;
        do {
            try {
                $latestPage = $this->getLatestPage();
                break;
            } catch (\Exception $exception) {
                $crashed++;
                if ($crashed === 6) {
                    throw $exception;
                }
            }
            sleep(5);
        } while ($crashed <= 5);
        return $latestPage;
    }

    private function getLatestPage()
    {
        $latestId = CacheApiFacade::getCachedLatestId() ?? $this->getLatestId();
        return APIFacade::getLastPage($latestId);
    }

    private function getLatestId()
    {
        $latestId = OrderFacade::getLatestRowId();
        CacheApiFacade::cacheLatestId($latestId);
        return $latestId;
    }

    /**
     * it only runs when there is not cached oder list
     * it gets all orders in one page accordion page number and last id from the cache
     * if it fails it will run again here and wont be in the queue
     * THIS JOB IS UNIQUE AND STAYS ONCE IN QUEUE
     */
    private function processGetOrderList($latestPage): void
    {
        // get order list
        while (!CacheApiFacade::hasOrderListCached()) {
            GetOrderListJob::dispatch($latestPage);
            sleep(5);
        }
    }


}
