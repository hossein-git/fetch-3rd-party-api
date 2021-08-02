<?php

namespace Modules\API\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\API\Facades\APIFacade;
use Modules\API\Facades\CacheApiFacade;
use Modules\Order\Facades\OrderFacade;

/**
 * this class send an API request to get the last page number
 */
class GetLastOrdersPageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 4;

    public function __construct()
    {
    }


    public function handle()
    {
        //get last id from local DB and save into cache if not exists
        $latestId = CacheApiFacade::getCachedLatestId() ?? $this->getLatestId();

//        if (!CacheApiFacade::hasLastOrderPage()) {
            $lastPage = APIFacade::getLastPage($latestId);
            CacheApiFacade::cacheLastOrdersPage($lastPage);
//        }
    }

    private function getLatestId()
    {
        $latestId = OrderFacade::getLatestRowId();
        CacheApiFacade::cacheLatestId($latestId);
        return $latestId;
    }
}
