<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\PreventiveOperation;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Preventive extends Model
{
    protected $fillable = ['name', 'vehicle_id', 'customer_id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function operations()
    {
        return $this->hasMany(PreventiveOperation::class);
    }
}
