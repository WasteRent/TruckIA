<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\MaintenanceAlert;
use App\Models\RepairOrder;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate',
        'registration_date',
        'kms',
        'chassis_maker',
        'chassis_model',
        'box_maker',
        'box_model'
    ];

    protected $casts = [
        'registration_date' => 'date:Y-m-d'
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }

    public function alerts()
    {
        return $this->hasMany(MaintenanceAlert::class);
    }


    public function getChassisAttribute()
    {
        return "{$this->chassis_maker} {$this->chassis_model}";
    }

    public function getBoxAttribute()
    {
        return "{$this->box_maker} {$this->box_model}";
    }
}
