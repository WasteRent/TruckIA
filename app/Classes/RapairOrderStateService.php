<?php

namespace App\Classes;

use App\Models\RepairOrder;
use App\Models\RepairOrderHistory;
use App\Models\RepairOrderState;
use Illuminate\Support\Facades\Auth;

class RapairOrderStateService
{
    public static function transit(int $repair_order_id, int $state_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $repair_order->update(['state_id' => $state_id]);
        
        RepairOrderHistory::create([
            'repair_order_id' => $repair_order_id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id
        ]);

        if ($state_id == RepairOrderState::FINISHED) {
            $repair_order->update(['finished_at' => new \DateTime]);
        }
    }
}
