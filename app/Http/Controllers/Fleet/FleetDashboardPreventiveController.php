<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetDashboardPreventiveController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = cache()->remember('vehicles_preventive_'. auth()->user()->fleet->id . '_' . md5(serialize($request->all())), now()->addHours(1), function () use ($request) {
            return Vehicle::filter($request->all())
                ->active()
                ->allowForUser()
                ->whereHas('counters')
                ->get()
                ->sortByDesc(function ($vehicle) {
                    return $vehicle->counters->where('completedPercent', '>=', 70)->count();
                });
        });

        $customers = Customer::whereHas('vehicles', function ($q) {
            $q->allowForUser();
        })->orderBy('name')->get();


        return view('fleet.dashboard.preventives', [
            'vehicles' => $vehicles,
            'chassis_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', '!=', 'equipment');
            })->orderBy('name')->get(),
            'equipment_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', 'equipment');
            })->orderBy('name')->get(),
            'chassis_models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models->sortBy('name') : collect([]),
            'equipment_models' => Manufacturer::find($request->equipment_maker_id) ? Manufacturer::find($request->equipment_maker_id)->models->sortBy('name') : collect([]),
            'customers' => $customers,
            'states' => VehicleState::all(),
        ]);
    }
}
