<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'date_time',
        'notes',
        'vehicle_id',
        'creator_user_id',
        'repair_order_id',
    ];

    protected $casts = [
        'date_time' => 'datetime:Y-m-d H:i:s',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopePending($query)
    {
        return $query->where('date_time', '>=', now());
    }
}
