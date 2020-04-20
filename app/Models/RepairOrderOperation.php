<?php

namespace App\Models;

use App\Models\File;
use App\Models\RepairOrder;
use App\User;
use Illuminate\Database\Eloquent\Model;

class RepairOrderOperation extends Model
{
    protected $fillable = [
        'user_id',
        'operation_family',
        'operation_subfamily',
        'operation_code',
        'operation_name',
        'operation_description',
        'estimated_time_in_hours',
        'real_time_in_hours',
        'garage_observations',
        'file_id',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function getAmount()
    {
        return $this->repairOrder->garage_hourly_fare * $this->real_time_in_hours;
    }


    public function isCompleted()
    {
        return !empty($this->completed_at);
    }
}
