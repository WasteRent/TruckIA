<?php

namespace App\Models;

use App\Classes\AlertService;
use App\Models\Vehicle;
use App\Preventive;
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
        'zip'
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
        return $this->belongsToMany(Vehicle::class, 'vehicle_customers');
    }

    public function preventives()
    {
        return $this->hasMany(Preventive::class);
    }

    public function notify(int $vehicle_id, string $title, string $message)
    {
        (new AlertService)->notify($this->user_id, $vehicle_id, $title, $message);
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
