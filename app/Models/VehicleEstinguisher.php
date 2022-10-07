<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleEstinguisher extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
