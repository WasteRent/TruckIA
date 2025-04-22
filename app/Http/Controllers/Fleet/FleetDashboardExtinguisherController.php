<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleEstinguisher;
use App\Models\VehicleLocation;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetDashboardExtinguisherController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::whereHas('vehicles', function ($q) {
            $q->allowForUser();
        })->orderBy('name')->get();

        return view('fleet.dashboard.extinguisher', [
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

            'customers' => $customers,
            'states' => VehicleState::where('id', '!=', VehicleState::OUT_OF_SERVICE)->where('id', '!=', VehicleState::SOLD)->where('id', '!=', VehicleState::DISCHARGED)->get(),
            'locations' => VehicleLocation::where('fleet_id', Auth::user()->fleet->id)->get(),
        ]);
    }

    private function expired(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->whereHas('estinguishers', function ($q) {
                $q->where('expiration_date', '<=', date('Y-m-d'));
            })
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy(
                VehicleEstinguisher::select('extinguisher_date')
                    ->whereColumn('vehicle_id', 'vehicles.id')
                    ->orderByDesc('extinguisher_date')
                    ->limit(1)
            )
            ->get();
    }

    private function comming(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->whereHas('estinguishers', function ($q) {
                $q->where('expiration_date', '>', date('Y-m-d'))
                    ->where('expiration_date', '<=', date('Y-m-d', strtotime('+90 days')));
            })
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy(
                VehicleEstinguisher::select('extinguisher_date')
                    ->whereColumn('vehicle_id', 'vehicles.id')
                    ->orderByDesc('extinguisher_date')
                    ->limit(1)
            )
            ->get();
    }
}
