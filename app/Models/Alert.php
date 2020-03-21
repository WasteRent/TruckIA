<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'user_id',
        'uuid',
        'vehicle_id',
        'title',
        'description'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
