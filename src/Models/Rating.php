<?php

namespace Cjmellor\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    protected $fillable = ['rating'];

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(config(key: 'auth.providers.users.model'));
    }
}
