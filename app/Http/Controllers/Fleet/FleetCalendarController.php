<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetCalendarController extends Controller
{
    public function index(Request $request)
    {
        $appointments = RepairOrder::filter($request->toArray())
                ->with('vehicle', 'garage')
                ->where('fleet_id', auth()->user()->fleet->id)
                ->where('appointment', ">=", now())
                ->orderBy('appointment', 'asc')
                ->get()
                ->map(function($or){
                    return (object)[
                        'date' => $or->appointment,
                        'order' => $or
                    ];
                });
        
        return view('fleet.calendar.index', [
            'appointments' => $appointments,
        ]);
    }
}
