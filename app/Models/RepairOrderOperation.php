<?php

namespace App\Models;

use App\Models\File;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderPart;
use App\User;
use Illuminate\Database\Eloquent\Model;

class RepairOrderOperation extends Model
{
    protected $fillable = [
        'user_id',
        'maintenance_plan_id',
        'maintenance_plan_name',
        'operation_family',
        'operation_subfamily',
        'operation_name',
        'operation_description',
        'estimated_time',
        'repair_order_id',
        'operation_attachment_file_id',
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

    public function operationAttachment()
    {
        return $this->belongsTo(File::class, 'operation_attachment_file_id');
    }

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function parts()
    {
        return $this->hasMany(RepairOrderPart::class);
    }

    public function maintenance_plan()
    {
        return $this->belongsTo(MaintenancePlan::class, 'maintenance_plan_id');
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
