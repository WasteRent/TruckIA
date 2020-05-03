<?php

namespace App\Models;

use App\Classes\AlertService;
use App\Models\Alert;
use App\Models\Garage;
use App\Models\Preventive;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{


    protected $fillable = [
        'user_id',
        'name',
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
        'notifications_email'
    ];
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseGroup::class, 'enterprise_group_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'assigned_customer_id');
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

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }

        if (isset($query['enterprise_group_id']) && $query['enterprise_group_id'] != null) {
            $filters[] = ['enterprise_group_id', $query['enterprise_group_id']];
        }
        
        return $filters;
    }
}
