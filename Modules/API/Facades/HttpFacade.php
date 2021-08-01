<?php

namespace Modules\API\Facades;


use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Modules\Base\BaseFacade;

/**
 * @method PromiseInterface|Response getRequest
 * @method PromiseInterface|Response postRequest
 */
class HttpFacade extends BaseFacade
{

}
