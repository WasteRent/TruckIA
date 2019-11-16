<?php

namespace App\Models;

use App\Models\MaintenanceOperation;
use Illuminate\Database\Eloquent\Model;

class MaintenancePlan extends Model
{

    public function operations()
    {
        return $this->hasMany(MaintenanceOperation::class);
    }
}
