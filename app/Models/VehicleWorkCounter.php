<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleWorkCounter extends Model
{
    protected $fillable = ['current', 'vehicle_id', 'type', 'max'];
}
