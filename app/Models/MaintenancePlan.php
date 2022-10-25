<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\VehicleWorkCounter;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenancePlan extends EloquentModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'manufacturer_id',
        'model_id',
        'version_id',
        'euro',
        'kms',
        'natural_hours',
        'work_hours',
        'can_hours',
        'grua_hours',
        'vehicle_category',
        'type',
        'original'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public function operations()
    {
        return $this->hasMany(MaintenancePlanOperation::class);
    }

    public function parts()
    {
        return $this->hasMany(SparePart::class, 'vehicle_maintenance_plan_id');
    }

    public function counters() {
        return $this->hasMany(VehicleWorkCounter::class, 'plan_id');
    }

    public function getFullnameAttribute()
    {
        return $this->name.' - '.optional($this->manufacturer)->name.' '.optional($this->model)->name.' '.optional($this->version)->name." ({$this->euro} ".($this->power_kw ? $this->power_kw.'kw)' : ')');
    }

    public function isDaily()
    {
        return $this->natural_hours == 24;
    }

    public function isWeekly()
    {
        return $this->natural_hours == 168;
    }

    public function fleet()
    {
        return $this->belongsToMany(Fleet::class, 'fleet_maintenance_plans');
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
        if (isset($query['model_id']) && $query['model_id'] != null) {
            $filters[] = ['model_id', '=', $query['model_id']];
        }
        if (isset($query['version_id']) && $query['version_id'] != null) {
            $filters[] = ['version_id', '=', $query['version_id']];
        }
        if (isset($query['type']) && $query['type'] != null) {
            $filters[] = ['type', '=', $query['type']];
        }
        if (isset($query['euro']) && $query['euro'] != null) {
            $filters[] = ['euro', '=', $query['euro']];
        }

        return $filters;
    }
}
