<?php

namespace App\Models;

use App\Models\Garage;
use App\Models\Operation;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{
    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'repair_order_operations');
    }
}
