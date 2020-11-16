<?php

namespace App\Models;

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
}
