<?php

namespace App\Models;

use App\Models\Operation;
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
        'longitude'
    ];
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
