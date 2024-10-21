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
        $repair_orders = RepairOrder::filter($request->toArray())->orderBy('id')->paginate(20);

        return view('fleet.mechanics.index', [
            'repair_orders' => $repair_orders,
        ]);
    }

}
