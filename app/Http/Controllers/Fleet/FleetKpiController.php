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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FleetKpiController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->job == 'driver') {
            return to_route('fleet.incidents.index');
        }

        $filters = $request->toArray();
        
        return view('fleet.dashboard.fleet.index', [
            'fleet_age' => $this->getFleetAge($filters),
            'vehicles_state' => $this->getVehiclesState($filters),
            'vehicles_owner' => $this->getVehiclesByOnwer($filters),
            'vehicles_mechanic' => $this->getVehiclesByMechanic($filters),
            'maintenance_chassis' => $this->getMaintenanceStatus('chassis', $filters),
            'maintenance_equipment' => $this->getMaintenanceStatus('equipment', $filters),
            'latest_incidents' => $this->getLatestIncidents($filters),
            'latest_alerts' => $this->getLatestAlerts($filters),
            'latest_activity' => $this->getLatestActivity($filters),
            'latest_orders' => $this->getLatestOrders($filters),
            'call_off_stats' => $this->getCallOffStats($filters),
            'itv_stats' => $this->getItvStats($filters),
            'tacograph_stats' => $this->getTacographStats($filters),
            'status' => $this->getStatus($filters),
        ]);
    }

    private function getItvStats(array $filters)
    {
        $cache_key = "itv_stats_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(24), function () use ($filters) {
            $vehicles = Vehicle::filter($filters)
                    ->allowForUser()
                    ->where('itv_exempt', false)
                    ->whereNotIn('state_id', [VehicleState::DISCHARGED, VehicleState::SOLD, VehicleState::OUT_OF_SERVICE])
                    ->get();

            $up_to_date = $vehicles->where('itv_date', '>=', today())->count();
            $passed = $vehicles->where('itv_date', '<', today())->count();

            return [
                'up_to_date' => $up_to_date,
                'passed' => $passed,
                'total' => $up_to_date + $passed,
            ];
        });
    }

    private function getTacographStats(array $filters)
    {
        $cache_key = "tacograph_stats_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(24), function () use($filters) {
            $vehicles = Vehicle::filter($filters)
                    ->allowForUser()
                    ->where('tachograph_exempt', false)
                    ->whereNotIn('state_id', [VehicleState::DISCHARGED, VehicleState::SOLD, VehicleState::OUT_OF_SERVICE])
                    ->get();

            $up_to_date = $vehicles->where('tachograph_date', '>=', today())->count();
            $passed = $vehicles->where('tachograph_date', '<', today())->count();

            return [
                'up_to_date' => $up_to_date,
                'passed' => $passed,
                'total' => $up_to_date + $passed,
            ];
        });
    }

    private function getCallOffStats(array $filters)
    {
        $cache_key = "call_off_stats_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(24), function () use ($filters) {
            $vehicles = Vehicle::filter($filters)
                    ->allowForUser()
                    ->with('stateHistory', 'customer')
                    ->where('state_id', '=', VehicleState::CALLOFF)
                    ->get();

            return $vehicles->map(function ($vehicle) {
                return [
                    'vehicle' => $vehicle,
                    'customer' => $vehicle->customer,
                    'days_in_call_off' => $vehicle->stateHistory->where('state_id', VehicleState::CALLOFF)->sortByDesc('created_at')->first()->created_at->diffInDays(),
                ];
            })->sortByDesc('days_in_call_off');
        });
    }

    private function getFleetAge(array $filters)
    {
        $cache_key = "fleet_age_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(24), function () use ($filters) {
            $vehicles = Vehicle::filter($filters)
                    ->whereNotNull('registration_date')
                    ->where('state_id', '!=', VehicleState::SOLD)
                    ->allowForUser()
                    ->where('is_service_vehicle', 0)
                    ->select('registration_date')
                    ->orderBy('registration_date')
                    ->get();

            $avg_years = $vehicles->map(function ($vehicle) {
                return Carbon::parse($vehicle->registration_date)->diffInDays() / 365;
            })->avg();

            $years = $vehicles->map(function ($vehicle) {
                return ['year' => date('Y', strtotime($vehicle->registration_date))];
            })
            ->groupBy('year')
            ->map(function ($item, $year) {
                return ['year' => $year, 'total' => count($item)];
            })->values();

            return [
                'avg_years' => number_format($avg_years, 2, ','),
                'years' => $years,
            ];
        });
    }

    private function getLatestOrders(array $filters)
    {
        $cache_key = "latest_orders_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(1), function () use ($filters) {
            return RepairOrder::filter($filters)
                    ->whereNull('finished_at')
                    ->whereHas('vehicle', function ($q) {
                        $q->allowForUser();
                    })
                    ->latest()
                    ->limit(6)
                    ->get();
        });
    }

    private function getLatestActivity()
    {
        return cache()->remember("latest_activity_" . auth()->user()->id, now()->addHours(1), function () {
            return ActivityFeed::query()
                ->where('user_id', auth()->user()->id)
                ->latest()
                ->limit(6)
                ->get();
        });
    }

    private function getLatestAlerts(array $filters)
    {
        $cache_key = "latest_alerts_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(1), function () use ($filters) {
            return Alert::filter($filters)
                ->where('dismissed', 0)
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->latest()
                ->limit(6)
                ->get();
        });
    }

    private function getVehiclesState(array $filters)
    {
        $cache_key = "vehicles_state_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(1), function () use ($filters) {
            $total = Vehicle::filter($filters)->where('state_id', '!=', VehicleState::SOLD)->allowForUser()->where('is_service_vehicle', 0)->count();

            return Vehicle::filter($filters)
                ->where('state_id', '!=', VehicleState::SOLD)
                ->allowForUser()
                ->where('is_service_vehicle', 0)
                ->get()
                ->groupBy('state_id')
                ->map(function ($batch) use ($total) {
                    return [
                        'id' => $batch->first()->state->id ?? '-',
                        'state' => $batch->first()->state->name ?? '-',
                        'count' => $batch->count(),
                        'percent' => number_format(($batch->count() / $total) * 100, 2, ',', '.'),
                    ];
                })->sortByDesc('count');
        });
    }

    private function getVehiclesByMechanic()
    {
        return cache()->remember("vehicles_by_mechanic_" . auth()->user()->id, now()->addHours(1), function () {
            $vehicles = Vehicle::with('mechanic')
                ->active()
                ->allowForUser()
                ->where('is_service_vehicle', 0)
                ->get();

            return $vehicles->groupBy('mechanic_user_id')->map(function ($vehicles, $mechanic_id) {
                $mechanic = empty($mechanic_id) ? 'Sin asignar' : optional(User::find($mechanic_id))->name;
                return ['name' => $mechanic, 'vehicles' => $vehicles->count(),
                ];
            })->values();
        });
    }

    private function getVehiclesByOnwer()
    {
        return cache()->remember("vehicles_by_owner_" . auth()->user()->id, now()->addHours(1), function () {
            $vehicles = Vehicle::where('state_id', '!=', VehicleState::SOLD)
                ->allowForUser()
                ->where('is_service_vehicle', 0)
                ->get();

            return $vehicles->groupBy('owner')->mapWithKeys(function ($chunk, $owner) {
                return [empty($owner) ? 'Sin asignar' : $owner => $chunk->count()];
            });
        });
    }

    private function getMaintenanceStatus($vehicle_category, array $filters)
    {
        $cache_key = "maintenance_status_{$vehicle_category}_" . auth()->user()->id . json_encode($filters);

        return cache()->remember($cache_key, now()->addHours(24), function () use ($vehicle_category, $filters) {
            return Vehicle::filter($filters)
                ->allowForUser()
                ->whereIn('state_id', [VehicleState::RENTED, VehicleState::LOAN, VehicleState::AVAILABLE])
                ->where('is_service_vehicle', 0)
                ->get()
                ->map(function ($vehicle) use ($vehicle_category) {
                    $passed = $vehicle->counters->where('vehicle_category', $vehicle_category)->filter(function ($counter) {
                        return $counter->completedPercent >= 100;
                    })->groupBy('vehicle_id')->count();

                    return [
                        'vehicle_id' => $vehicle->id,
                        'state' => $passed > 0 ? 'Pasado' : 'Al día',
                    ];
                });
        });
    }

    private function getLatestIncidents(array $filters)
    {
        $cache_key = "latest_incidents_" . auth()->user()->id . json_encode($filters);
        
        return cache()->remember($cache_key, now()->addHours(2), function () use ($filters) {
            return VehicleIncident::filter($filters)
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        });
        
    }

    private function getStatus()
    {
        return cache()->remember("status_" . auth()->user()->id, now()->addHours(1), function () {
            return Vehicle::active()
                ->allowForUser()
                ->where('is_service_vehicle', 0)
                ->get()
                ->map(function ($vehicle) {
                    $maker = $vehicle->equipments->count() > 0
                        ? $vehicle->equipments->where('type', '!=', 'Grua')->pluck('maker.name')->first()
                    : $vehicle->chassisMaker?->name;

                return [
                    'type' => [
                        'id' => $vehicle->type->id ?? '-',
                        'name' => $vehicle->type->name ?? '-',
                    ],
                    'state' => [
                        'id' => $vehicle->state->id,
                        'name' => $vehicle->state->name,
                    ],
                    'maker' => $maker,
                ];
            })
            ->groupBy('type.id')
            ->sortByDesc(function ($i) {
                return count($i);
            })
            ->map(function ($vehicles) {
                return $vehicles->groupBy('maker');
            });
        });
    }
}
