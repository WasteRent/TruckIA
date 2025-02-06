<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairOrderOperationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_operation_id',
        'user_id',
        'hours_spent',
    ];

    public function repairOrderOperation()
    {
        return $this->belongsTo(RepairOrderOperation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
