<?php

namespace App\Listeners;

use App\Classes\AlertService;
use App\Events\IncidentClosed;
use App\Events\IncidentOpened;
use App\Events\RepairOrderCreated;
use App\Events\RepairOrderStateChanged;
use App\Events\VehicleCreated;
use App\Events\VehicleReassgined;
use App\Events\VehicleStateChanged;
use App\Models\ActivityFeed;
use App\Models\AlertType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendToAlerts
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $alertService = new AlertService;

        switch (get_class($event)) {
            case IncidentClosed::class:
                $alertService->to($event->incident->vehicle->fleet)->forVehicle($event->incident->vehicle)->notify(
                    "Incidencia cerrada",
                    "#{$event->incident->id} Incidencia cerrada",
                    null,
                    AlertType::INCIDENT_CLOSED
                );
                break;
            case IncidentOpened::class:
                $alertService->to($event->incident->vehicle->fleet)->forVehicle($event->incident->vehicle)->notify(
                    "Incidencia abierta",
                    "#{$event->incident->id} Incidencia cerrada",
                    null,
                    AlertType::INCIDENT_OPENED
                );
                break;
            case RepairOrderCreated::class:
                $alertService->to($event->repairOrder->fleet)->forVehicle($event->repairOrder->vehicle)->notify(
                    "O.R.",
                    "O.R. #{$event->repairOrder->id} abierta",
                    null,
                    AlertType::ORDER_CREATED
                );
                break;
            case RepairOrderStateChanged::class:
                $alertService->to($event->repairOrder->fleet)->forVehicle($event->repairOrder->vehicle)->notify(
                    "O.R.",
                    "O.R. #{$event->repairOrder->id} cambia a '{$event->state->name}'",
                    null,
                    AlertType::ORDER_STATE_CHANGED
                );
                break;
            case VehicleCreated::class:
                $alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    "Nuevo vehículo",
                    "Vehículo creado '{$event->vehicle->plate}'",
                    null,
                    AlertType::VEHICLE_CREATED
                );
                break;
            case VehicleReassgined::class:
                $alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    "Cambio de cliente",
                    "Vehículo asignado a '{$event->vehicle->customer->name}'",
                    null,
                    AlertType::VEHICLE_REASSIGNED
                );
                break;
            case VehicleStateChanged::class:
                $alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    "Cambio de estado",
                    "Estado del vehículo cambiado a '{$event->state->name}'",
                    null,
                    AlertType::VEHICLE_STATE_CHANGED
                );
                break;
        }
    }
}
