<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleetMaintenanceOperationRestriction extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
}
