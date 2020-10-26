<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleState extends Model
{
    public const DISCHARGED = 1;
    public const SOLD = 2;
    public const RENTED = 3;
    public const AVAILABLE = 4;
    public const WAITING_MAINTENANCE = 5;
    public const MAINTENANCE_PASSED = 6;
    public const OUT_OF_SERVICE = 7;
}
