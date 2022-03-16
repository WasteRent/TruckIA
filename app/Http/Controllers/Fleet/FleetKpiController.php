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

        $counters = Vehicle::active()->where('fleet_id', auth()->user()->fleet->id)->with('counters')->get()->pluck('counters')->flatten();
        $total = $counters->count();
        $maintenance = $counters->map(function ($counter) {
            return ['type' => $counter->completedPercent >= 100 ? 'Pasado' : 'Al día'];
        })
        ->groupBy('type')
        ->map(function ($batch, $type) use ($total) {
            return [
                'type' => $type,
                'count' => $batch->count(),
                'percent' => number_format(($batch->count() / $total) * 100, 2, ',', '.')
            ];
        });

        return view('fleet.dashboard.kpis', [
            'total' => $total,
            'vehicles' => $vehicles,
            'maintenance' => $maintenance
        ]);
    }
}
