<?php

namespace Modules\Base\Http;


use Modules\Base\BaseFacade;
use Modules\Base\Responses\AndroidResponses;
use Modules\Base\Responses\VueResponses;

class ResponderFacade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        // here we can change the response according different devices/requests
        if (request('client') == 'android') {
            return AndroidResponses::class;
        }
        return VueResponses::class;
    }
}
