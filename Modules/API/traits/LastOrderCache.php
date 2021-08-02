<?php

namespace Modules\API\traits;


use Illuminate\Support\Facades\Cache;

trait LastOrderCache
{

    public function cacheLastOrdersPage(int $page)
    {
        return Cache::put(self::FIRST_PAGE_CACHE_KEY, $page);
    }

    public function getLastOrdersPage()
    {
        return Cache::get(self::FIRST_PAGE_CACHE_KEY);
    }

    public function goNextPage()
    {
        return Cache::decrement(self::FIRST_PAGE_CACHE_KEY, 1);
    }

    public function removeLastOrderPage()
    {
        return Cache::forget(self::FIRST_PAGE_CACHE_KEY);
    }

    public function hasLastOrderPage(): bool
    {
        return Cache::has(self::FIRST_PAGE_CACHE_KEY);
    }

    public function cacheLatestId(int $id)
    {
        return Cache::put(self::LAST_ID_CACHE_KEY, $id);
    }

    public function getCachedLatestId()
    {
        return Cache::get(self::LAST_ID_CACHE_KEY);
    }

    public function removeCachedLatestId()
    {
        return Cache::forget(self::LAST_ID_CACHE_KEY);
    }

    public function increaseLastId(int $amount)
    {
        return Cache::increment(self::LAST_ID_CACHE_KEY, $amount);
    }
}
