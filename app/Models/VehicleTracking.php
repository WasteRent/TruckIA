<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTracking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'fired_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
