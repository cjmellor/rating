<?php

namespace Cjmellor\Rating\Tests\Models;

use Cjmellor\Rating\Concerns\CanBeRated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\{User};

class FakeUser extends User
{
    use CanBeRated;
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;
}
