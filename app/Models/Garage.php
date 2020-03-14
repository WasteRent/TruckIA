<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\RepairOrder;
use App\Models\Speciality;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
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
        'hourly_price'
    ];
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function getStarsAverage()
    {
        return $this->specialities->filter(function ($spec) {
            return $spec->pivot->stars > 0;
        })->avg('pivot.stars');
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
