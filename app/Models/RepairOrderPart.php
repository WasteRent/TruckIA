<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOrderPart extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'repair_order_id',
        'repair_order_operation_id',
        'manufacturer',
        'description',
        'quantity',
        'unit_price',
        'name',
        'reference',
        'type',
        'total_price',
    ];

    public function operation()
    {
        return $this->belongsTo(RepairOrderOperation::class, 'repair_order_operation_id');
    }
}
