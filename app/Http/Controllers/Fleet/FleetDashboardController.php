<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\Models\VehicleWorkCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetDashboardController extends Controller
{
    public function preventives(Request $request)
    {
        $allowed_vehicles = Vehicle::filter($request->all())->pluck('id')->toArray();

        $counters = VehicleWorkCounter::whereHas('vehicle', function ($query) {
            $query->whereNull('discharged_date');
            $query->where('fleet_id', Auth::user()->fleet->id);
        })
        ->get()
        ->filter(function ($counter) use ($allowed_vehicles) {
            return in_array($counter->vehicle->id, $allowed_vehicles);
        })
        ->filter(function ($counter) {
            return $counter->completedPercent >= 70;
        })->sortByDesc(function ($counter) {
            return ($counter->max - $counter->current);
        })->groupBy('vehicle_id');

        return view('fleet.dashboard.preventives', [
            'vehicle_counters' => $counters,
            'customers' => Customer::where('fleet_id', Auth::user()->fleet->id)->get(),
            'states' => VehicleState::all()
        ]);
    }

    public function itv(Request $request)
    {
        return view('fleet.dashboard.itv', [
            'ongoing' => $this->ongoingItv($request->all()),
            'comming' => $this->commingItv($request->all()),
            'expired' => $this->expiredItv($request->all()),

            'customers' => Customer::where('fleet_id', Auth::user()->fleet->id)->get(),
            'states' => VehicleState::all()
        ]);
    }

    private function ongoingItv(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->whereHas('repairOrders', function ($q) {
                $q->whereNotNull('scheduled_itv_date');
                $q->whereNull('finished_at');
            })
            ->orderBy('itv_date')
            ->get();
    }

    private function expiredItv(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('itv_exempt', 0)
            ->where('itv_date', '<=', date('Y-m-d'))
            ->orderBy('itv_date')
            ->get();
    }

    private function commingItv(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('itv_exempt', 0)
            ->where('itv_date', '>', date('Y-m-d'))
            ->where('itv_date', '<=', date('Y-m-d', strtotime('+60 days')))
            ->orderBy('itv_date')
            ->get();
    }
}
