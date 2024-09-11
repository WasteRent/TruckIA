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

class FleetKpiController extends Controller
{
    public function index()
    {
        if (auth()->user()->job == 'driver') {
            return to_route('fleet.incidents.index');
        }
        
        return view('fleet.dashboard.fleet.index', [
            'fleet_age' => $this->getFleetAge(),
            'vehicles_state' => $this->getVehiclesState(),
            'vehicles_owner' => $this->getVehiclesByOnwer(),
            'vehicles_mechanic' => $this->getVehiclesByMechanic(),
            'maintenance_chassis' => $this->getMaintenanceStatus('chassis'),
            'maintenance_equipment' => $this->getMaintenanceStatus('equipment'),
            'latest_incidents' => $this->getLatestIncidents(),
            'latest_alerts' => $this->getLatestAlerts(),
            'latest_activity' => $this->getLatestActivity(),
            'latest_orders' => $this->getLatestOrders(),
            'call_off_stats' => $this->getCallOffStats(),

            'status' => $this->getStatus(),
        ]);
    }

    private function getCallOffStats()
    {
        return cache()->remember("call_off_stats_", now()->addHours(24), function () {
            $vehicles = Vehicle::query()
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

    private function getFleetAge()
    {
        return cache()->remember("fleet_age_", now()->addHours(24), function () {
            $vehicles = Vehicle::query()
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

    private function getLatestOrders()
    {
        return cache()->remember("latest_orders_", now()->addHours(1), function () {
            return RepairOrder::query()
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
        return cache()->remember("latest_activity_", now()->addHours(1), function () {
            return ActivityFeed::query()
                ->where('fleet_id', auth()->user()->fleet->id)
                ->latest()
                ->limit(6)
                ->get();
        });
    }

    private function getLatestAlerts()
    {
        return Alert::query()
            ->where('dismissed', 0)
            ->whereHas('vehicle', function ($q) {
                $q->allowForUser();
            })
            ->latest()
            ->limit(6)
            ->get();
    }

    private function getVehiclesState()
    {
        return cache()->remember("vehicles_state_", now()->addHours(1), function () {
            $total = Vehicle::where('state_id', '!=', VehicleState::SOLD)->allowForUser()->where('is_service_vehicle', 0)->count();

            return Vehicle::where('state_id', '!=', VehicleState::SOLD)
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
        return cache()->remember("vehicles_by_mechanic_", now()->addHours(1), function () {
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
        return cache()->remember("vehicles_by_owner_", now()->addHours(1), function () {
            $vehicles = Vehicle::where('state_id', '!=', VehicleState::SOLD)
                ->allowForUser()
                ->where('is_service_vehicle', 0)
                ->get();

            return $vehicles->groupBy('owner')->mapWithKeys(function ($chunk, $owner) {
                return [empty($owner) ? 'Sin asignar' : $owner => $chunk->count()];
            });
        });
    }

    private function getMaintenanceStatus($vehicle_category)
    {
        return cache()->remember("maintenance_status_{$vehicle_category}_", now()->addHours(24), function () use ($vehicle_category) {
            return Vehicle::query()
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

    private function getLatestIncidents()
    {
        return VehicleIncident::query()
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->orderByDesc('id')
                ->limit(6)
                ->get();
    }

    private function getStatus()
    {
        return cache()->remember("status_", now()->addHours(1), function () {
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
