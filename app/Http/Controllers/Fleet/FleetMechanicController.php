<?php

namespace App\Http\Controllers\Fleet;

use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FleetMechanicController extends Controller
{
    
    public function index(Request $request)
    {
        $repair_orders = RepairOrder::filter($request->toArray())
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->latest()
                ->paginate(20);

        return view('fleet.mechanics.index', [
            'repair_orders' => $repair_orders,
        ]);
    }

}
