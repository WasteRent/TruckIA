<?php

namespace App\Listeners;

use App\Classes\Odoo\OdooClient;
use App\Events\VehicleStateChanged;
use App\Models\VehicleState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateVehicleStateOdoo
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
        $client = app(OdooClient::class);

        $data = $client->executeAction('product.template', 'pnt_get_json_data');

        $vehicle = collect($data['result']['Vehiculos'])
                    ->where('MatriculaChasis', $event->vehicle->plate)
                    ->first();

        if ($vehicle && $this->canChangeState($event->state->id)) {
            $result = $client->executeAction('product.template', 'pnt_trucki_set_data', [
                'id' => $vehicle['Id'],
                'state' => $this->getState($event->state->id)
            ]);
        }
    }

    private function getState(int $id) {
        $states = [
            VehicleState::DISCHARGED => 'down',
            VehicleState::SOLD => 'sold',
            VehicleState::RENTED => 'rent',
            VehicleState::AVAILABLE => 'available',
            VehicleState::WAITING_MAINTENANCE => 'waiting',
            VehicleState::OUT_OF_SERVICE => 'out_of_service',
            VehicleState::GARAGE    => 'garage',
            VehicleState::LOAN      => 'lending',
            VehicleState::RESERVED  => 'booked',
        ];

        return isset($states[$id]) ? $states[$id] : null;
    }

    private function canChangeState(int $id) {
        return $this->getState($id) != null;
    }
}
