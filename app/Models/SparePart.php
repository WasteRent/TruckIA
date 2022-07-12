<?php

namespace App\Models;

use App\Classes\Helpers;

class SparePart extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'manufacturer',
        'reference',
        'short_reference',
        'unit_price',
        'description',
        'vehicle_manufacturer_id',
        'vehicle_model_id',
        'vehicle_maintenance_plan_id',
        'vehicle_maintenance_plan_operation_id',
    ];

    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = strtoupper($value);
    }

    public function getFormattedPrice()
    {
        return number_format($this->unit_price, 2, ',', '.').' €';
    }

    public function vehicleManufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'vehicle_manufacturer_id');
    }

    public function vehicleModel()
    {
        return $this->belongsTo(Model::class, 'vehicle_model_id');
    }

    public function vehiclePlan()
    {
        return $this->belongsTo(MaintenancePlan::class, 'vehicle_maintenance_plan_id');
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['reference']) && $query['reference'] != null) {
            $filters[] = ['short_reference', '=', Helpers::shortReference($query['reference'])];
        }
        if (isset($query['description']) && $query['description'] != null) {
            $filters[] = ['description', 'LIKE', '%'.$query['description'].'%'];
        }

        return $filters;
    }
}
