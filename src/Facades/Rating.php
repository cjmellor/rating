<?php

namespace Cjmellor\Rating\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cjmellor\Rating\Models\Rating
 */
class Rating extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Cjmellor\Rating\Models\Rating::class;
    }
}
