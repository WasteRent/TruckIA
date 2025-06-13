<?php

namespace App\Models;

use App\Classes\Helpers;

class SparePart extends \Illuminate\Database\Eloquent\Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

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
        'stock',
        'fleet_id',
        'customer_id',
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

    public function scopeAllowForUser($query)
    {
        return $query->where('fleet_id', auth()->user()->fleet->id);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
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
        if (isset($query['manufacturer']) && $query['manufacturer'] != null) {
            $filters[] = ['manufacturer', 'LIKE', '%'.$query['manufacturer'].'%'];
        }
        if (isset($query['customer_id']) && $query['customer_id'] != null) {
            $filters[] = ['customer_id', '=', $query['customer_id']];
        }
        return $filters;
    }
}
