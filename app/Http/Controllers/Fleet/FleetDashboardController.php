<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleWorkCounter;

class FleetDashboardController extends Controller
{
    public function index()
    {
        $counters = VehicleWorkCounter::whereHas('vehicle', function ($query) {
            $query->whereNull('discharged_date');
        })
        ->get()
        ->filter(function ($counter) {
            return $counter->type == 'hours' && ($counter->max - $counter->current) <= 100;
        })->sortByDesc(function ($counter) {
            return $counter->current > $counter->max ? $counter->max : ($counter->max - $counter->current);
        });

        return view('fleet.dashboard.index', [
            'counters' => $counters
        ]);
    }
}
