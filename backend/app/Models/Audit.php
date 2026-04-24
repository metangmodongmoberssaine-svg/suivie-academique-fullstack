<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'audits';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'request' => 'array',
        'response' => 'array'
    ];
}
