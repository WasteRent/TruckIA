<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class VehicleWorkCounter extends Model
{
    protected $fillable = ['current', 'vehicle_id', 'type', 'max', 'notified'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function reset()
    {
        $this->current = 0;
        $this->notified = 0;
        $this->save();
    }
}
