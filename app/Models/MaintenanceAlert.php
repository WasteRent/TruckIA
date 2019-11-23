<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class MaintenanceAlert extends Model
{
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
