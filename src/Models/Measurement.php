<?php

namespace GameSpecU\Metrics\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = [
        'type',
        'value',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
