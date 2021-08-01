<?php

namespace Modules\API\Services;


use Illuminate\Support\Facades\Cache;

class CacheApiService
{
    const FIRST_PAGE_CACHE_KEY = 'first_order_page';
    const ORDER_LIST_CACHE_KEY = 'order_list';
    const LAST_ID_CACHE_KEY = 'latest_order_id';
    const ORDER_DETAILS_CACHE_KEY = 'order_details_';

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
        return Cache::increment(self::FIRST_PAGE_CACHE_KEY, 1);
    }

    public function cacheOrderDetails(array $items, int $order_id)
    {
        return Cache::put(self::ORDER_DETAILS_CACHE_KEY.$order_id, $items);
    }

    public function removeCacheOrderDetails(int $order_id)
    {
        return Cache::forget(self::ORDER_DETAILS_CACHE_KEY.$order_id);
    }

    public function getCustomer($order_id)
    {
        return $this->readCachedDetails($order_id)['customer'] ?? null;
    }

    public function readCachedDetails($order_id)
    {
        return Cache::get(self::ORDER_DETAILS_CACHE_KEY.$order_id);
    }

    public function getBillingAddress($order_id)
    {
        return $this->readCachedDetails($order_id)['billing_address'] ?? null;
    }

    public function getShippingAddress($order_id)
    {
        return $this->readCachedDetails($order_id)['shipping_address'] ?? null;
    }

    public function cacheOrderList($data)
    {
        return Cache::put(self::ORDER_LIST_CACHE_KEY, $data);
    }

    public function getCachedOrderList()
    {
        return Cache::get(self::ORDER_LIST_CACHE_KEY);
    }

    public function removeCachedOrderList()
    {
        return Cache::forget(self::ORDER_LIST_CACHE_KEY);
    }

    public function cacheLatestId(int $id)
    {
        return Cache::put(self::LAST_ID_CACHE_KEY, $id);
    }

    public function getCachedLatestId()
    {
        return Cache::get(self::LAST_ID_CACHE_KEY);
    }

    public function increaseLastId(int $amount)
    {
        return Cache::increment(self::LAST_ID_CACHE_KEY, $amount);
    }
}
