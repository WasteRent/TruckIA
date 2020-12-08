<?php

namespace App\Models;

use App\Models\RepairOrderOperation;
use Illuminate\Database\Eloquent\Model;

class RepairOrderPart extends Model
{
    protected $fillable = [
        'repair_order_id',
        'repair_order_operation_id',
        'manufacturer',
        'reference',
        'description',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function operation()
    {
        return $this->belongsTo(RepairOrderOperation::class, 'repair_order_operation_id');
    }
}
