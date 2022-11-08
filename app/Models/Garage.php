<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Garage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fleet_id',
        'name',
        'notifications_email',
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
        'cif',
        'latitude',
        'longitude',
        'hourly_price',
        'web',
        'is_manager',
        'notes'
    ];

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)
            ->orderby('date_time');
    }

    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'garage_specialities')
            ->withTimestamps()
            ->withPivot('stars');
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

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'entity_relation_id')->where('role', 'garage');
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
        if (isset($filters['province']) && $filters['province'] != null) {
            $query->where('province', 'LIKE', "%{$filters['province']}%");
        }
        if (isset($filters['state']) && $filters['state'] != null) {
            $query->where('state', 'LIKE', "%{$filters['state']}%");
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

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_garages');
    }
}
