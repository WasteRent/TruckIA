<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RepairOrderHistory extends Model
{
    protected $fillable = [
        'state_id',
        'user_id',
        'repair_order_id',
    ];

    public function state()
    {
        return $this->belongsTo(RepairOrderState::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
