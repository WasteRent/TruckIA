<?php

namespace App\Models;

use App\Operation;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
