<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\ActivityFeed;
use App\Models\Alert;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use App\Models\VehicleState;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FleetKpiController extends Controller
{
    public function index()
    {
        return view('fleet.dashboard.fleet.index', [
            'fleet_age' => $this->getFleetAge(),
            'vehicles_state' => $this->getVehiclesState(),
            'vehicles_owner' => $this->getVehiclesByOnwer(),
            'vehicles_mechanic' => $this->getVehiclesByMechanic(),
            'maintenance' => $this->getMaintenanceStatus(),
            'latest_incidents' => $this->getLatestIncidents(),
            'latest_alerts' => $this->getLatestAlerts(),
            'latest_activity' => $this->getLatestActivity(),
            'latest_orders' => $this->getLatestOrders(),

            'status' => $this->getStatus(),
        ]);
    }

    private function getFleetAge() {
        $vehicles = Vehicle::query()
                ->whereNotNull('manufacturing_date')
                ->where('state_id', '!=', VehicleState::SOLD)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->select('manufacturing_date')
                ->orderBy('manufacturing_date')
                ->get();

        $avg_years = $vehicles->map(function($vehicle) {
            return Carbon::parse($vehicle->manufacturing_date)->diffInDays() / 365;
        })->avg();

        $years = $vehicles->map(function($vehicle) {
            return ['year' => date('Y', strtotime($vehicle->manufacturing_date))];
        })
        ->groupBy('year')
        ->map(function($item, $year) {
            return ['year' => $year, 'total' => count($item)];
        })->values();

        return [
            'avg_years' => number_format($avg_years, 2, ','),
            'years' => $years
        ];
    }

    private function getLatestOrders() {
        return RepairOrder::query()
                ->whereNull('finished_at')
                ->where('fleet_id', Auth::user()->fleet->id)
                ->latest()
                ->limit(6)
                ->get();
    }

    private function getLatestActivity() {
        return ActivityFeed::query()
            ->where('fleet_id', auth()->user()->fleet->id)
            ->latest()
            ->limit(6)
            ->get();
    }   

    private function getLatestAlerts() {
        return Alert::query()
            ->where('dismissed', 0)
            ->where('fleet_id', Auth::user()->fleet->id)
            ->latest()
            ->limit(6)
            ->get();
    }

    private function getVehiclesState() {
        $total = Vehicle::where('state_id', '!=', VehicleState::SOLD)->where('fleet_id', auth()->user()->fleet->id)->count();
        return Vehicle::where('state_id', '!=', VehicleState::SOLD)->where('fleet_id', auth()->user()->fleet->id)
            ->get()->groupBy('state_id')
            ->map(function ($batch) use ($total) {
                return [
                    'id' => $batch->first()->state->id ?? '-',
                    'state' => $batch->first()->state->name ?? '-',
                    'count' => $batch->count(),
                    'percent' => number_format(($batch->count() / $total) * 100, 2, ',', '.')
                ];
            })->sortByDesc('count');
    }

    private function getVehiclesByMechanic() {
        $vehicles = Vehicle::with('mechanic')->active()->where('fleet_id', auth()->user()->fleet->id)->get();

        return $vehicles->groupBy('mechanic_user_id')->map(function($vehicles, $mechanic_id) {
            $mechanic = empty($mechanic_id) ? 'Sin asignar' : User::find($mechanic_id)->name;
            return [
                'name' => $mechanic,
                'vehicles' => $vehicles->count()
            ];
        })->values();
    }

    private function getVehiclesByOnwer() {
        $vehicles = Vehicle::where('state_id', '!=', VehicleState::SOLD)->where('fleet_id', auth()->user()->fleet->id)->get();

        return $vehicles->groupBy('owner')->mapWithKeys(function($chunk, $owner) {
            return [empty($owner) ? 'Sin asignar' : $owner => $chunk->count()];
        });
    }

    private function getMaintenanceStatus() {
        return Vehicle::query()
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
    }

    private function getLatestIncidents() {
        return VehicleIncident::query()
                ->whereNull('closed_at')
                ->whereHas('vehicle', function($q) {
                    $q->where('fleet_id', Auth::user()->fleet->id);
                })
                ->orderByDesc('id')
                ->limit(6)
                ->get();
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
