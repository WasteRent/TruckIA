<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\Models\VehicleWorkCounter;
use Illuminate\Support\Facades\Auth;

class FleetDashboardController extends Controller
{
    public function preventives()
    {
        $counters = VehicleWorkCounter::whereHas('vehicle', function ($query) {
            $query->whereNull('discharged_date');
            $query->where('fleet_id', Auth::user()->fleet->id);
        })
        ->get()
        ->filter(function ($counter) {
            return $counter->completedPercent >= 70;
        })->sortByDesc(function ($counter) {
            return ($counter->max - $counter->current);
        })->groupBy('vehicle_id');

        return view('fleet.dashboard.preventives', [
            'vehicle_counters' => $counters
        ]);
    }

    public function itv()
    {
        return view('fleet.dashboard.itv', [
            'ongoing' => $this->ongoingItv(),
            'comming' => $this->commingItv(),
            'expired' => $this->expiredItv()
        ]);
    }

    private function ongoingItv()
    {
        return Vehicle::active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->whereHas('repairOrders', function ($q) {
                $q->whereNotNull('scheduled_itv_date');
                $q->whereNull('finished_at');
            })
            ->orderBy('itv_date')
            ->get();
    }

    private function expiredItv()
    {
        return Vehicle::active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('itv_exempt', 0)
            ->where('itv_date', '<=', date('Y-m-d'))
            ->orderBy('itv_date')
            ->get();
    }

    private function commingItv()
    {
        return Vehicle::active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('itv_exempt', 0)
            ->where('itv_date', '>', date('Y-m-d'))
            ->where('itv_date', '<=', date('Y-m-d', strtotime('+15 days')))
            ->orderBy('itv_date')
            ->get();
    }
}
