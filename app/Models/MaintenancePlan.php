<?php

namespace App\Models;

use App\Models\MaintenancePlan;
use App\Models\MaintenancePlanOperation;
use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class MaintenancePlan extends EloquentModel
{
    protected $fillable = [
        'name',
        'description',
        'manufacturer_id',
        'model_id',
        'kms',
        'natural_hours',
        'work_hours',
        'can_hours'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    
    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function operations()
    {
        return $this->hasMany(MaintenancePlanOperation::class);
    }

    public function getFullnameAttribute()
    {
        return $this->name . " - " . optional($this->manufacturer)->name . " " . optional($this->model)->name;
    }

    public function isDaily()
    {
        return $this->natural_hours == 24;
    }

    public function isWeekly()
    {
        return $this->natural_hours == 168;
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }

        if (isset($query['manufacturer_id']) && $query['manufacturer_id'] != null) {
            $filters[] = ['manufacturer_id', '=', $query['manufacturer_id']];
        }
        
        return $filters;
    }
}
