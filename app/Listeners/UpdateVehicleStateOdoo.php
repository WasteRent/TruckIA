<?php

namespace App\Listeners;

use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use App\Events\VehicleStateChanged;
use App\Models\VehicleState;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateVehicleStateOdoo implements ShouldQueue
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

        $filepath = storage_path('app/data.json');
        $reader = new OdooReader($filepath);

        foreach ($reader->iterate() as $item) {
            if ($item->MatriculaChasis == $event->vehicle->plate && $this->canChangeState($event->state->id)) {
                $client->executeAction('product.template', 'pnt_trucki_set_data', [
                    'id' => $item->Id,
                    'state' => $this->getState($event->state->id)
                ]);
                $this->info($item->MatriculaChasis);
            }
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
            VehicleState::CALLOFF  => 'callof',
            VehicleState::PDI  => 'pdi',
        ];

        return isset($states[$id]) ? $states[$id] : null;
    }

    private function canChangeState(int $id) {
        return $this->getState($id) != null;
    }
}
