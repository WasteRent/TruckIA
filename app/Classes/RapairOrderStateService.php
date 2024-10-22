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
    $repair_order = RepairOrder::with('relatedIncident', 'vehicle.counters', 'operations')->findOrFail($repair_order_id);
    
    // Si ya está en el mismo estado, no hacer nada
    if ($repair_order->state_id == $state_id) {
        return;
    }
    
    // Actualizar el estado de la orden
    $repair_order->update(['state_id' => $state_id]);

    // Crear registro de historial de estado
    RepairOrderHistory::create([
        'repair_order_id' => $repair_order_id,
        'state_id' => $state_id,
        'user_id' => Auth::id(),
    ]);

    // Disparar evento de cambio de estado
    event(new RepairOrderStateChanged($repair_order, RepairOrderState::find($state_id)));

    // Si el estado es "Mantenimiento"
    if ($state_id == RepairOrderState::MAINTENECE) {
        $repair_order->update(['finished_at' => now()]);

        // Si hay un incidente relacionado y esta es la última orden pendiente, cerrar el incidente
        if ($repair_order->related_incident_id && $repair_order->relatedIncident->repair_orders()->whereNotIn('state_id', [
                RepairOrderState::CANCELED, 
                RepairOrderState::FINISHED, 
                RepairOrderState::MAINTENECE
            ])->count() == 1) {
            $repair_order->relatedIncident->update(['closed_at' => now()]);
        }

        // Obtener los planes de mantenimiento usados y reiniciar los contadores
        $used_plans = $repair_order->operations->pluck('maintenance_plan_id')->unique()->filter();
        
        if ($used_plans->isNotEmpty()) {
            $maintenance_plans = MaintenancePlan::whereIn('id', $used_plans)->get();
            RapairOrderStateService::resetVehicleCounters($repair_order->vehicle, $maintenance_plans);
        }

        // Disparar evento de actualización de mantenimiento
        event(new MaintenanceUpdated($repair_order->vehicle_id));
    }
}

/**
 * Resetea los contadores de un vehículo para los planes de mantenimiento proporcionados.
 */
private static function resetVehicleCounters($vehicle, $maintenance_plans)
{
    // Cargar todos los contadores relevantes de una vez
    $counters = $vehicle->counters()->whereIn('type', ['kms', 'work_hours', 'grua_hours', 'natural_hours'])->get();

    foreach ($maintenance_plans as $plan) {
        // Filtrar los contadores que coinciden con el plan actual en función del tipo y la categoría de vehículo
        $counters_to_reset = $counters->filter(function ($counter) use ($plan) {
            switch ($counter->type) {
                case 'kms':
                    return $counter->vehicle_category == $plan->vehicle_category && $counter->max == $plan->kms;
                case 'work_hours':
                    return $counter->vehicle_category == $plan->vehicle_category && $counter->max == $plan->can_hours;
                case 'grua_hours':
                    return $counter->vehicle_category == $plan->vehicle_category && $counter->max == $plan->grua_hours;
                case 'natural_hours':
                    return $counter->vehicle_category == $plan->vehicle_category && $counter->max == $plan->natural_hours;
                default:
                    return false;
            }
        });

        // Resetear todos los contadores que coinciden con el plan actual
        foreach ($counters_to_reset as $counter) {
            $counter->reset();
        }
    }
}
}
