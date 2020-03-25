<?php

namespace App;

use App\Models\Vehicle;
use App\PreventiveOperation;
use Illuminate\Database\Eloquent\Model;

class Preventive extends Model
{
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function operations()
    {
        return $this->hasMany(PreventiveOperation::class);
    }
}
