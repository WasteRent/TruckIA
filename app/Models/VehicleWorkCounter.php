<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class VehicleWorkCounter extends Model
{
    protected $fillable = ['current', 'vehicle_id', 'type', 'vehicle_category', 'description', 'max', 'notified', 'plan_id'];

    public function getCompletedPercentAttribute()
    {
        return round(100 * $this->current / $this->max, 2);
    }

    public function isThresholdReached()
    {
        return $this->completedPercent >= 70;
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function reset()
    {
        $this->update(['current' => 0, 'notified' => 0]);
    }
}
