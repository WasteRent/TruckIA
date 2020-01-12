<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\MaintenanceAlert;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\RepairOrder;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Vehicle extends EloquentModel
{
    protected $fillable = [
        'fleet_id',
        'plate',
        'registration_date',
        'kms',
        'chassis_maker_id',
        'chassis_model_id',
        'box_maker_id',
        'box_model_id'
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

    public function chassisMaker()
    {
        return $this->belongsTo(Manufacturer::class, 'chassis_maker_id');
    }

    public function chassisModel()
    {
        return $this->belongsTo(Model::class, 'chassis_model_id');
    }

    public function boxMaker()
    {
        return $this->belongsTo(Manufacturer::class, 'box_maker_id');
    }

    public function boxModel()
    {
        return $this->belongsTo(Model::class, 'box_model_id');
    }


    public function getChassisAttribute()
    {
        return "{$this->chassisMaker->name} {$this->chassisModel->name}";
    }

    public function getBoxAttribute()
    {
        $make = $this->boxMaker ? $this->boxMaker->name:'';
        $model = $this->boxModel ? $this->boxModel->name:'';
        return "{$make} {$model}";
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['plate']) && $query['plate'] != null) {
            $filters[] = ['plate', '=', $query['plate']];
        }
        
        return $filters;
    }
}
