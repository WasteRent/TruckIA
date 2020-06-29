<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;

class FleetDashboardController extends Controller
{
    public function preventives()
    {
        $counters = VehicleWorkCounter::whereHas('vehicle', function ($query) {
            $query->whereNull('discharged_date');
        })
        ->get()
        ->filter(function ($counter) {
            return $counter->max - $counter->current <= 100;
        })->sortByDesc(function ($counter) {
            return $counter->current > $counter->max ? $counter->max : ($counter->max - $counter->current);
        });

        return view('fleet.dashboard.preventives', [
            'counters' => $counters
        ]);
    }

    public function itv()
    {
        $expired = Vehicle::active()->where('itv_date', '<=', date('Y-m-d'))->orderBy('itv_date')->get();
        $comming = Vehicle::active()
                ->where('itv_date', '>', date('Y-m-d'))
                ->where('itv_date', '<=', date('Y-m-d', strtotime('+15 days')))
                ->orderBy('itv_date')
                ->get();

        return view('fleet.dashboard.itv', [
            'expired' => $expired,
            'comming' => $comming
        ]);
    }
}
