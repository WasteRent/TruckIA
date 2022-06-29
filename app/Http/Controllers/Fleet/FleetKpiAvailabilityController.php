<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\ActivityFeed;
use App\Models\Alert;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;

class FleetKpiAvailabilityController extends Controller
{
    public function index()
    {
        return view('fleet.dashboard.availability.index', [
            'status' => $this->getStatus(),
        ]);
    }

    private function getStatus() {
        //https://flatlogic.com/blog/examples-of-dashboard-templates-for-tracking-kpi-s/
        //https://xvelopers.com/demos/html/paper-panel/index.html
        //https://designreset.com/cork/ltr/demo4/index2.html
        
        return Vehicle::active()
            ->where('fleet_id', auth()->user()->fleet->id)
            ->get()
            ->map(function($vehicle) {
                $maker = $vehicle->equipments->count() > 0 
                    ? optional($vehicle->equipments->where('type', '!=', 'Grua')->first())->maker
                    : $vehicle->chassisMaker;

                return [
                    'type' => [
                        'id' => $vehicle->type->id ?? '-',
                        'name' => $vehicle->type->name ?? '-',
                    ],
                    'state' => [
                        'id' => $vehicle->state->id,
                        'name' => $vehicle->state->name
                    ],
                    'maker' => optional($maker)->name,
                    'maker_id' => optional($maker)->id
                ];
            })
            ->groupBy('type.id')
            ->sortByDesc(function($i) {
                return count($i);
            })
            ->map(function($vehicles) {
                return $vehicles->groupBy('maker');
            });
    }

}
