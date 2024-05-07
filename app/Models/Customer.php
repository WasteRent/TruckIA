<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'cif',
        'enterprise_group_id',
        'contact1',
        'email1',
        'phone1',
        'contact2',
        'email2',
        'phone2',
        'contact3',
        'email3',
        'phone3',
        'contact4',
        'email4',
        'phone4',
        'address',
        'state',
        'province',
        'zip',
        'notifications_email',
        'notes',
    ];

    public function getFullAddressAttribute()
    {
        return $this->address ? "{$this->address}, {$this->zip}, {$this->state}, {$this->province}" : '';
    }

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseGroup::class, 'enterprise_group_id');
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'assigned_customer_id');
    }

    public function vehiclesHistory()
    {
        return $this->hasMany(VehicleCustomerHistory::class)->latest();
    }

    public function garages()
    {
        return $this->belongsToMany(Garage::class, 'customer_garages');
    }

    public function preventives()
    {
        return $this->hasMany(Preventive::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public static function filter(array $filters)
    {
        $query = Customer::query();

        if (isset($filters['name']) && $filters['name'] != null) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }
        if (isset($filters['enterprise_group_id']) && $filters['enterprise_group_id'] != null) {
            $query->where(function ($subquery) use ($filters) {
                $subquery->where('enterprise_group_id', $filters['enterprise_group_id']);
            });
        }
        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicles', function ($q) use ($filters) {
                $q->where('plate', 'LIKE', "%{$filters['plate']}%");
            });
        }
        if (isset($filters['with_vehicles']) && $filters['with_vehicles'] != null) {
            $query->whereHas('vehicles');
        }

        return $query;
    }
}
