<?php

namespace Modules\API\Http;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpRequest
{
    /**
     * @var PendingRequest
     */
    private $http;

    public function __construct()
    {
        $this->http = Http::withHeaders(
            [
                'Accept' => 'application/json',
            ]
        );
    }

    /**
     * @param  string  $url
     * @param  array  $params
     * @return PromiseInterface|Response
     */
    public function getRequest(string $url = '', array $params = [])
    {
        return $this->http->get($url, array_merge(['api_key' => config('api_config.auth_api_key')], $params));
    }


    /**
     * @param  string  $url
     * @param  array  $params
     * @return PromiseInterface|Response
     */
    public function postRequest(string $url = '', array $params = [])
    {
        return $this->http->post($url, array_merge(['api_key' => config('api_config.auth_api_key')], $params));
    }
}
