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
use App\Mail\RepairOrderMail;
use App\Models\AlertType;
use App\Models\RepairOrderState;
use Illuminate\Support\Facades\Mail;

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
                // $alertService->to($event->incident->vehicle->fleet)->forVehicle($event->incident->vehicle)->notify(
                //     __("Incidencia cerrada"),
                //     "#{$event->incident->id} " . __('Incidencia cerrada'),
                //     null,
                //     AlertType::INCIDENT_CLOSED
                // );
                break;
            case IncidentOpened::class:
                // $alertService->to($event->incident->vehicle->fleet)->forVehicle($event->incident->vehicle)->notify(
                //     __("Incidencia abierta"),
                //     "#{$event->incident->id} " . __('Incidencia cerrada'),
                //     null,
                //     AlertType::INCIDENT_OPENED
                // );
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
                /*if ($event->state->id == RepairOrderState::AUTHORIZED && $event->repairOrder->garage->notifications_email) {
                    $mail = new RepairOrderMail($event->repairOrder);
                    foreach (explode(',', $event->repairOrder->garage->notifications_email) as $recipient) {
                        Mail::to($recipient)->queue($mail);
                    }
                }*/
                break;
            case VehicleCreated::class:
                /*$alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    __('Nuevo vehículo'),
                    __('Vehículo creado')." '{$event->vehicle->plate}'",
                    "/fleet/vehicles/{$event->vehicle->id}",
                    AlertType::VEHICLE_CREATED
                );*/
                break;
            case VehicleReassgined::class:
                /*$alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    __('Cambio de cliente'),
                    __('Vehículo asignado a')." '{$event->vehicle->customer->name}'",
                    "/fleet/vehicles/{$event->vehicle->id}",
                    AlertType::VEHICLE_REASSIGNED
                );*/
                break;
            case VehicleStateChanged::class:
                /*$alertService->to($event->vehicle->fleet)->forVehicle($event->vehicle)->notify(
                    __('Cambio de estado'),
                    __('Estado del vehículo cambiado a')." '{$event->state->name}'",
                    "/fleet/vehicles/{$event->vehicle->id}",
                    AlertType::VEHICLE_STATE_CHANGED
                );*/
                break;
        }
    }
}
