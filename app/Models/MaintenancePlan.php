<?php

namespace App\Models;

use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class MaintenancePlan extends EloquentModel
{
    protected $fillable = [
        'name',
        'frequency',
        'description',
        'manufacturer_id',
        'model_id',
        'frequency_type'
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
        return $this->belongsToMany(Operation::class, 'maintenance_plan_operations');
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
