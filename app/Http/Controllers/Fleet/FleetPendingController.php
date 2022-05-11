<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetPendingController extends Controller
{
    public function index(Request $request)
    {
        return view('fleet.pending.index', [
            'repair_orders' => []
        ]);
    }
}
