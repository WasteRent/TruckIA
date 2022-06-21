<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetPendingController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->toArray();

        if (!$request->query('assigned_user_id') ) {
            $filters['assigned_user_id'] = auth()->id();
        }

        $orders = RepairOrder::filter($filters)->inProgress()->latest()->get();
        $incidents = VehicleIncident::filter($filters)->whereNull('closed_at')->get();
        $users = auth()->user()->fleet->users()->whereHas('incidents')->get();

        return view('fleet.pending.index', [
            'repair_orders' => $orders,
            'incidents' => $incidents,
            'users' => $users
        ]);
    }
}
