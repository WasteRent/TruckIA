<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleLocation;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetDashboardItvController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::whereHas('vehicles', function ($q) {
            $q->allowForUser();
        })->orderBy('name')->get();

        return view('fleet.dashboard.itv', [
            'ongoing' => $this->ongoingItv($request->all()),
            'comming' => $this->commingItv($request->all()),
            'expired' => $this->expiredItv($request->all()),
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

    private function ongoingItv(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->whereHas('repairOrders', function ($q) {
                $q->whereNotNull('scheduled_itv_date');
                $q->whereNull('finished_at');
            })
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy('itv_date')
            ->get();
    }

    private function expiredItv(array $filters = [])
    {
        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->where('itv_exempt', 0)
            ->where('itv_date', '<=', date('Y-m-d'))
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy('itv_date')
            ->get();
    }

    private function commingItv(array $filters = [])
    {
        $days = Auth::user()->fleet->id == 1 ? 90 : 400;

        return Vehicle::filter($filters)
            ->active()
            ->allowForUser()
            ->where('itv_exempt', 0)
            ->where('itv_date', '>', date('Y-m-d'))
            ->where('itv_date', '<=', date('Y-m-d', strtotime("+{$days} days")))
            ->where('state_id', '!=', VehicleState::SOLD)
            ->where('state_id', '!=', VehicleState::DISCHARGED)
            ->orderBy('itv_date')
            ->get();
    }
}
