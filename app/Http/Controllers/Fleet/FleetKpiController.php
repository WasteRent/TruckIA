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
            'maintenance' => $maintenance
        ]);
    }
}
