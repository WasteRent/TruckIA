<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class VehicleCustomerHistory extends Model
{
    protected $fillable = ['vehicle_id', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
