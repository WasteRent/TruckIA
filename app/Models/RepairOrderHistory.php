<?php

namespace App\Models;

use App\Models\RepairOrderState;
use Illuminate\Database\Eloquent\Model;

class RepairOrderHistory extends Model
{
    protected $fillable = [
        'state_id',
        'repair_order_id'
    ];

    public function state()
    {
        return $this->belongsTo(RepairOrderState::class);
    }
}
