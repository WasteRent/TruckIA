<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
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

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_customers');
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
