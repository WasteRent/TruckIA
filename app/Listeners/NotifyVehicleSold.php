<?php

namespace App\Listeners;

use App\Events\VehicleStateChanged;
use App\Mail\AlertMail;
use App\Models\VehicleState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyVehicleSold implements ShouldQueue
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
    public function handle(VehicleStateChanged $event)
    {
        // $mail = new AlertMail(
        //     $event->vehicle,
        //     'Vendido',
        //     'El vehículo ha sido cambiado en Odoo a estado vendido.',
        //     route('fleet.vehicles.show', $event->vehicle->id)
        // );

        // Mail::to(['dramirez@truckts.com', 'ltin@wasterent.es', 'bcarracedo@wasterent.es', 'satroberto@wasterent.es'])->queue($mail);
    }

    public function shouldQueue(VehicleStateChanged $event)
    {
        return $event->state->id == VehicleState::SOLD && in_array($event->vehicle->fleet_id, [1, 6]);
    }
}
