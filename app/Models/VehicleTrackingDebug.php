<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTrackingDebug extends Model
{
    protected $fillable = [
        'provider',
        'service_key',
        'status',
        'response',
        'error_message',
    ];

    protected $casts = [
        'response' => 'array',
    ];
}

