<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleStateHistory extends Model
{
    protected $fillable = ['state_id', 'user_id', 'vehicle_id'];
}
