<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\Garage;
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
        'equipment_maker_id',
        'equipment_model_id',
        'equipment2_maker_id',
        'equipment2_model_id',
        'equipment3_maker_id',
        'equipment3_model_id',
        'warranty_chassis',
        'warranty_equipment1',
        'warranty_equipment2',
        'warranty_equipment3'
    ];

    public function setPlateAttribute($value)
    {
        $this->attributes['plate'] = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $value));
    }

    public function garages()
    {
        return $this->belongsToMany(Garage::class, 'vehicle_garages');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'vehicle_customers');
    }

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

    public function equipmentMaker()
    {
        return $this->belongsTo(Manufacturer::class, 'equipment_maker_id');
    }

    public function equipmentModel()
    {
        return $this->belongsTo(Model::class, 'equipment_model_id');
    }

    public function equipment2Maker()
    {
        return $this->belongsTo(Manufacturer::class, 'equipment2_maker_id');
    }

    public function equipment2Model()
    {
        return $this->belongsTo(Model::class, 'equipment2_model_id');
    }

    public function equipment3Maker()
    {
        return $this->belongsTo(Manufacturer::class, 'equipment3_maker_id');
    }

    public function equipment3Model()
    {
        return $this->belongsTo(Model::class, 'equipment3_model_id');
    }


    public function getChassisAttribute()
    {
        return "{$this->chassisMaker->name} {$this->chassisModel->name}";
    }

    public function getEquipmentAttribute()
    {
        $maker = $this->equipmentMaker->name ?? '';
        $model = $this->equipmentModel->name ?? '';
        return "{$maker} {$model}";
    }

    public function getEquipment2Attribute()
    {
        $maker = $this->equipment2Maker->name ?? '';
        $model = $this->equipment2Model->name ?? '';
        return "{$maker} {$model}";
    }

    public function getEquipment3Attribute()
    {
        $maker = $this->equipment3Maker->name ?? '';
        $model = $this->equipment3Model->name ?? '';
        return "{$maker} {$model}";
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
