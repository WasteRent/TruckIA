<?php

namespace App\Models;

use App\Models\Garage;
use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'garage_id',
        'vehicle_id',
        'maintenance_plan_id',
        'remarks'
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function maintenance_plan()
    {
        return $this->belongsTo(MaintenancePlan::class);
    }
}
