<?php

namespace Modules\Base;

use Illuminate\Support\Facades\Facade;

abstract class BaseFacade extends Facade
{
    static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }

    /**
     * favade accessor set by namespace and class name in child classes
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::class;
    }
}
