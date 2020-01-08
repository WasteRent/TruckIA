<?php

namespace App\Models;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'repair_order_operations');
    }
}
