<?php

namespace Cjmellor\Rating\Exceptions;

use Exception;

class MaxRatingException extends Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Maximum rating cannot be more than '.config('rating.max_rating'));
    }
}
