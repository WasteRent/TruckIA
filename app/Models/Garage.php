<?php

namespace App\Models;

use App\Classes\AlertService;
use App\Classes\Alertable;
use App\Models\Alert;
use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\RepairOrder;
use App\Models\Speciality;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use Alertable;

    protected $fillable = [
        'name',
        'garage_email',
        'garage_phone',
        'garage_name',
        'administration_email',
        'administration_phone',
        'administration_name',
        'spare_parts_email',
        'spare_parts_phone',
        'spare_parts_name',
        'management_email',
        'management_phone',
        'management_name',
        'official_service1_manufacturer_id',
        'official_service2_manufacturer_id',
        'official_service3_manufacturer_id',
        'official_service4_manufacturer_id',
        'official_service5_manufacturer_id',
        'opening_hours',
        'address',
        'state',
        'province',
        'zip',
        'latitude',
        'longitude',
        'hourly_price',
        'web'
    ];
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }
    
    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'garage_specialities')
            ->withTimestamps()
            ->withPivot('stars');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_garages');
    }

    public function officialService1()
    {
        return $this->belongsTo(Manufacturer::class, 'official_service1_manufacturer_id');
    }

    public function officialService2()
    {
        return $this->belongsTo(Manufacturer::class, 'official_service2_manufacturer_id');
    }

    public function officialService3()
    {
        return $this->belongsTo(Manufacturer::class, 'official_service3_manufacturer_id');
    }

    public function officialService4()
    {
        return $this->belongsTo(Manufacturer::class, 'official_service4_manufacturer_id');
    }

    public function officialService5()
    {
        return $this->belongsTo(Manufacturer::class, 'official_service5_manufacturer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'entity_relation_id');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function getStarsAverage()
    {
        return $this->specialities->filter(function ($spec) {
            return $spec->pivot->stars > 0;
        })->avg('pivot.stars');
    }

    public static function filter(array $filters)
    {
        $query = Garage::query();

        if (isset($filters['name']) && $filters['name'] != null) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }
        if (isset($filters['official_service_id']) && $filters['official_service_id'] != null) {
            $query->where(function ($subquery) use ($filters) {
                $subquery->where('official_service1_manufacturer_id', $filters['official_service_id'])
                     ->orWhere('official_service2_manufacturer_id', $filters['official_service_id'])
                     ->orWhere('official_service3_manufacturer_id', $filters['official_service_id'])
                     ->orWhere('official_service4_manufacturer_id', $filters['official_service_id'])
                     ->orWhere('official_service5_manufacturer_id', $filters['official_service_id']);
            });
        }

        return $query;
    }
}
