<?php

namespace NjoguAmos\Jenga\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NjoguAmos\Jenga\Jenga
 */
class Jenga extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NjoguAmos\Jenga\Jenga::class;
    }
}
