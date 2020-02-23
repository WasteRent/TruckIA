<?php

namespace App\Models;

use App\Models\Fleet;
use App\Models\RepairOrder;
use App\Models\Speciality;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
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

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
