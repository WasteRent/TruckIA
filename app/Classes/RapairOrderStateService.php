<?php

namespace App\Classes;

use App\Models\RepairOrder;
use App\Models\RepairOrderHistory;

class RapairOrderStateService
{
    public static function transit(int $repair_order_id, int $state_id)
    {
        RepairOrder::findOrFail($repair_order_id)->update(['state_id' => $state_id]);
        RepairOrderHistory::create([
            'repair_order_id' => $repair_order_id,
            'state_id' => $state_id
        ]);
    }
}
