<?php

namespace NjoguAmos\JengaAPI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\JengaAPI\JengaAPI
 */
class JengaAPI extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NjoguAmos\JengaAPI\JengaAPI::class;
    }
}
