<?php

namespace Lugmety\Auth\Http\Facades;

use Illuminate\Support\Facades\Facade;
use Lugmety\Auth\Services\Singleton\AppHeader;

/**
 * @method static string getToken()
 * @method static array getAllHeaders()
 */
class AppHeaderFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AppHeader::class;
    }
}