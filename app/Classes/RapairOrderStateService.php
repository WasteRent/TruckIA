<?php

namespace App\Classes;

use App\Events\MaintenanceUpdated;
use App\Events\RepairOrderStateChanged;
use App\Http\Controllers\Fleet\FleetRepairOrdersController;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderHistory;
use App\Models\RepairOrderState;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;

class RapairOrderStateService
{
    public static function transit(int $repair_order_id, int $state_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $incident = VehicleIncident::find($repair_order->related_incident_id);
        $pending_incident_orders = $incident?->repair_orders()->whereNotIn('state_id', [RepairOrderState::CANCELED, RepairOrderState::FINISHED, RepairOrderState::MAINTENANCE])->count() ?? 0;

        if ($repair_order->state_id == $state_id) {
            return;
        }

        $repair_order->update(['state_id' => $state_id]);


        RepairOrderHistory::create([
            'repair_order_id' => $repair_order_id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id,
        ]);

        if ($state_id == RepairOrderState::MAINTENANCE || $state_id == RepairOrderState::FINISHED) {
            // Actualizamos el repair order
            $repair_order->update(['finished_at' => new \DateTime]);

            // Si el incidente relacionado está pendiente y es el único, cerramos el incidente
            if ($repair_order->related_incident_id && $pending_incident_orders == 1) {
                $repair_order->relatedIncident()->update(['closed_at' => now()]);
            }

            // Obtenemos los planes de mantenimiento utilizados
            $used_plans_id = $repair_order->operations->pluck('maintenance_plan_id')->unique()->filter();
            $used_plans = MaintenancePlan::find($used_plans_id);


            $counters = collect();
            foreach ($used_plans as $plan) {
                $kms = collect();
                $work_hours = collect();
                $grua_hours = collect();
                $natural_hours = collect();

                // Filtrar solo si los valores no son nulos
                if (!is_null($plan->kms)) {
                    $kms = $repair_order->vehicle->counters()->where([
                        ['type', 'kms'],
                        ['vehicle_category', $plan->vehicle_category],
                        ['max', $plan->kms],
                    ])->get();
                }

                if (!is_null($plan->work_hours)) {
                    $work_hours = $repair_order->vehicle->counters()->where([
                        ['type', 'work_hours'],
                        ['vehicle_category', $plan->vehicle_category],
                        ['max', $plan->work_hours],
                    ])->get();
                }

                if (!is_null($plan->grua_hours)) {
                    $grua_hours = $repair_order->vehicle->counters()->where([
                        ['type', 'grua_hours'],
                        ['vehicle_category', $plan->vehicle_category],
                        ['max', $plan->grua_hours],
                    ])->get();
                }

                if (!is_null($plan->natural_hours)) {
                    $natural_hours = $repair_order->vehicle->counters()->where([
                        ['type', 'natural_hours'],
                        ['vehicle_category', $plan->vehicle_category],
                        ['max', $plan->natural_hours],
                    ])->get();
                }

                // Almacenar todos los contadores combinados en la colección
                $counters->push($kms->merge($work_hours)->merge($natural_hours));
            }
            foreach ($counters->flatten() as $counter) {
                $counter->update([
                    'current' => 0,
                    'notified' => 0,
                    'max' => 480000 // Mantener el valor original o ajustarlo
                ]);
            }
            
        }
        event(new RepairOrderStateChanged($repair_order, RepairOrderState::find($state_id)));
    }
}
