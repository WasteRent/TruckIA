<?php

namespace App\Models;

use App\Models\MaintenanceOperation;
use Illuminate\Database\Eloquent\Model;

class MaintenancePlan extends Model
{
    protected $fillable = [
        'name',
        'frequency',
        'description'
    ];

    public function operations()
    {
        return $this->hasMany(MaintenanceOperation::class);
    }
}
