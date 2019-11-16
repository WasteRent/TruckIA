<?php

namespace App\Models;

use App\Models\MaintenanceOperationType;
use Illuminate\Database\Eloquent\Model;

class MaintenanceOperation extends Model
{
    public function type()
    {
        return $this->belongsTo(MaintenanceOperationType::class, 'operation_type_id');
    }
}
