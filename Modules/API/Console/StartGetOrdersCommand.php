<?php

namespace Modules\API\Console;

use Illuminate\Console\Command;
use Modules\API\Facades\CacheApiFacade;
use Modules\API\Jobs\GetLastOrdersPageJob;
use Modules\API\Jobs\GetOrderListJob;
use Modules\Order\SaveOrderHandler;


class StartGetOrdersCommand extends Command
{

    protected $signature = 'start-take-orders';

    protected $description = 'Start to take last page orders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        GetLastOrdersPageJob::dispatch();
        $latestId = CacheApiFacade::getCachedLatestId();
        sleep(5);
        if (!$latestId) {
            $this->handle();
        }

        try {
            GetOrderListJob::dispatch();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        sleep(8);
        if (!CacheApiFacade::getCachedOrderList()) {
            $this->handle();
        }

        SaveOrderHandler::saveDetails();

    }


}
