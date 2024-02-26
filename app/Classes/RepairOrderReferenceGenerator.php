<?php

namespace App\Classes;

use App\Models\Fleet;
use Illuminate\Support\Facades\Auth;

class RepairOrderReferenceGenerator
{
    public static function generate(Fleet $fleet)
    {
        if ($fleet->order_prefix == null) {
            return null;
        }

        $last_order = $fleet->repairOrders()->whereNotNull('reference')->orderByDesc('reference')->first();

        $last_order_suffix = $last_order ? (int)substr($last_order->reference, -4) : 0;

        return date('Y') . $fleet->order_prefix . str_pad($last_order_suffix + 1, 4, 0, STR_PAD_LEFT);
    }
}
