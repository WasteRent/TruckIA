<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetDashboardCraneController extends Controller
{
    public function index(Request $request)
    {
        return view('fleet.dashboard.crane', [
            'comming' => $this->comming($request->all()),
            'expired' => $this->expired($request->all()),
            'chassis_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', '!=', 'equipment');
            })->orderBy('name')->get(),
            'equipment_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', 'equipment');
            })->orderBy('name')->get(),
            'chassis_models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models->sortBy('name') : collect([]),
            'equipment_models' => Manufacturer::find($request->equipment_maker_id) ? Manufacturer::find($request->equipment_maker_id)->models->sortBy('name') : collect([]),

            'customers' => Customer::where('fleet_id', Auth::user()->fleet->id)->get(),
            'states' => VehicleState::where('id', '!=', VehicleState::OUT_OF_SERVICE)->where('id', '!=', VehicleState::SOLD)->where('id', '!=', VehicleState::DISCHARGED)->get(),
        ]);
    }

    private function expired(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('crane_revision_date', '<=', date('Y-m-d'))
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy('crane_revision_date')
            ->get();
    }

    private function comming(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->allowForUser()
            ->active()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->where('crane_revision_date', '>', date('Y-m-d'))
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy('crane_revision_date')
            ->get();
    }
}