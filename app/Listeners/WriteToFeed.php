<?php

namespace App\Listeners;

use App\Events\IncidentClosed;
use App\Events\IncidentOpened;
use App\Events\RepairOrderCreated;
use App\Events\RepairOrderStateChanged;
use App\Events\VehicleCreated;
use App\Events\VehicleReassgined;
use App\Events\VehicleStateChanged;
use App\Models\ActivityFeed;

class WriteToFeed
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
        switch (get_class($event)) {
            case IncidentClosed::class:
                ActivityFeed::create([
                    'fleet_id' => $event->incident->user->fleet->id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "Incidencia cerrada #{$event->incident->id}",
                    'description' => substr(strip_tags($event->incident->incidence), 300),
                    'type' => 'incident_closed',
                    'url' => route('fleet.vehicles.incidents.index', $event->incident->vehicle),
                ]);
                break;
            case IncidentOpened::class:
                ActivityFeed::create([
                    'fleet_id' => $event->incident->user->fleet->id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "Incidencia abierta #{$event->incident->id}",
                    'description' => substr(strip_tags($event->incident->incidence), 300),
                    'type' => 'incident_opened',
                    'url' => route('fleet.vehicles.incidents.index', $event->incident->vehicle),
                ]);
                break;
            case RepairOrderCreated::class:
                ActivityFeed::create([
                    'fleet_id' => $event->repairOrder->fleet_id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "O.R abierta #{$event->repairOrder->id}, vehículo '{$event->repairOrder->vehicle->plate}'",
                    'type' => 'order_opened',
                    'url' => route('fleet.repair-orders.show', $event->repairOrder),
                ]);
                break;
            case RepairOrderStateChanged::class:
                ActivityFeed::create([
                    'fleet_id' => $event->repairOrder->fleet_id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "O.R #{$event->repairOrder->id}, vehículo '{$event->repairOrder->vehicle->plate}', cambia a '{$event->state->name}'",
                    'type' => 'order_state_updated',
                    'url' => route('fleet.repair-orders.show', $event->repairOrder),
                ]);
                break;
            case VehicleCreated::class:
                ActivityFeed::create([
                    'fleet_id' => $event->vehicle->fleet_id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "Vehículo creado '{$event->vehicle->plate}'",
                    'type' => 'vehicle_created',
                    'url' => route('fleet.vehicles.show', $event->vehicle),
                ]);
                break;
            case VehicleReassgined::class:
                ActivityFeed::create([
                    'fleet_id' => $event->vehicle->fleet_id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "Vehículo '{$event->vehicle->plate}' asignado a '{$event->vehicle->customer->name}'",
                    'type' => 'vehicle_reassigned',
                    'url' => route('fleet.vehicles.show', $event->vehicle),
                ]);
                break;
            case VehicleStateChanged::class:
                ActivityFeed::create([
                    'fleet_id' => $event->vehicle->fleet_id,
                    'user_id' => auth()->user()->id ?? 987,
                    'title' => "Estado del vehículo '{$event->vehicle->plate}' cambiado a '{$event->state->name}'",
                    'type' => 'vehicle_state_changed',
                    'url' => route('fleet.vehicles.show', $event->vehicle),
                ]);
                break;
        }
    }
}
