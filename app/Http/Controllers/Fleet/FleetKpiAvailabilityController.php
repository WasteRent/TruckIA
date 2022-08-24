<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class FleetKpiAvailabilityController extends Controller
{
    public function index()
    {
        return view('fleet.dashboard.availability.index', [
            'status' => $this->getStatus(),
        ]);
    }

    private function getStatus()
    {
        return Vehicle::active()
            ->where('fleet_id', auth()->user()->fleet->id)
            ->get()
            ->map(function ($vehicle) {
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
                        'name' => $vehicle->state->name,
                    ],
                    'maker' => optional($maker)->name,
                    'maker_id' => optional($maker)->id,
                ];
            })
            ->groupBy('type.id')
            ->sortByDesc(function ($i) {
                return count($i);
            })
            ->map(function ($vehicles) {
                return $vehicles->groupBy('maker');
            });
    }
}
