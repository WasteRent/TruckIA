<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class FleetKpiController extends Controller
{
    public function index()
    {
        $total = Vehicle::where('fleet_id', auth()->user()->fleet->id)->count();
        $vehicles = Vehicle::where('fleet_id', auth()->user()->fleet->id)->get()->groupBy('state_id')->map(function ($batch) use ($total) {
            return [
                'id' => $batch->first()->state->id ?? '-',
                'state' => $batch->first()->state->name ?? '-',
                'count' => $batch->count(),
                'percent' => number_format(($batch->count() / $total) * 100, 2, ',', '.')
            ];
        })->sortByDesc('count');

        $maintenance = Vehicle::query()
            ->where('fleet_id', auth()->user()->fleet->id)
            ->whereIn('state_id', [3, 9])
            ->get()
            ->map(function ($vehicle) {
                $passed = $vehicle->counters->filter(function ($counter) {
                    return $counter->completedPercent >= 100;
                })->groupBy('vehicle_id')->count();

                return [
                    'vehicle_id' => $vehicle->id,
                    'state' => $passed > 0 ? 'Pasado' : 'Al día'
                ];
            });

        return view('fleet.dashboard.kpis', [
            'total' => Vehicle::where('fleet_id', auth()->user()->fleet->id)->count(),
            'vehicles' => $vehicles,
            'maintenance' => $maintenance,
            'status' => $this->getStatus()
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
                    ? $vehicle->equipments->where('type', '!=', 'Grua')->pluck('maker.name')->first()
                    : $vehicle->chassisMaker->name;

                return [
                    'type' => [
                        'id' => $vehicle->type->id ?? '-',
                        'name' => $vehicle->type->name ?? '-',
                    ],
                    'state' => [
                        'id' => $vehicle->state->id,
                        'name' => $vehicle->state->name
                    ],
                    'maker' => $maker
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
