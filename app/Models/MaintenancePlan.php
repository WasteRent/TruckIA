<?php

namespace App\Models;

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
        return $this->belongsToMany(Operation::class, 'maintenance_plan_operations');
    }
}
