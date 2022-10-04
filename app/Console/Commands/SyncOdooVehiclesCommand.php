<?php

namespace App\Console\Commands;

use App\Classes\Odoo\OdooClient;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncOdooVehiclesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = app(OdooClient::class);

        $data = $client->executeAction('product.template', 'pnt_get_json_data');

        foreach (collect($data['result']['Vehiculos']) as $item) {
            $vehicle = Vehicle::where('plate', $item['MatriculaChasis'])->first();

            $odoo_state_id = $this->getStateId($item['Estado']);

            if ($vehicle && $odoo_state_id && $vehicle->state_id != $odoo_state_id) {
                $vehicle->changeState($odoo_state_id);
                $this->info("Odoo: {$vehicle->plate} cambio de estado de trucki:{$vehicle->state_id} a odoo:{$odoo_state_id}");
                Log::info("Odoo: {$vehicle->plate} cambio de estado de trucki:{$vehicle->state_id} a odoo:{$odoo_state_id}");
            }
        }
    }

    private function getStateId(string $name) {
        $states = [
            'down' => VehicleState::DISCHARGED,
            'sold' => VehicleState::SOLD,
            'rent' => VehicleState::RENTED,
            'available' => VehicleState::AVAILABLE,
            'waiting' => VehicleState::WAITING_MAINTENANCE,
            'out_of_service' => VehicleState::OUT_OF_SERVICE,
            'garage' => VehicleState::GARAGE,
            'lending' => VehicleState::LOAN,
            'booked' => VehicleState::RESERVED,
        ];

        return isset($states[$name]) ? $states[$name] : null;
    }
}
