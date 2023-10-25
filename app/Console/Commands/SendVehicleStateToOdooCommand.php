<?php

namespace App\Console\Commands;

use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendVehicleStateToOdooCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:send-state-to-odoo';

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
        $filepath = storage_path('app/data.json');
        $client->batchAction('product.template', 'pnt_get_json_data', [], $filepath);

        $reader = new OdooReader($filepath);

        foreach ($reader->iterate() as $item) {
            $this->info("odoo:" . $item->MatriculaChasis);
            $vehicle = Vehicle::where('plate', $item->MatriculaChasis)->first();
            if ($vehicle && $this->getState($vehicle->state->id) && $this->getState($vehicle->state->id) != $item->Estado) {
                $client->executeAction('product.template', 'pnt_trucki_set_data', [
                    'id' => $item->Id,
                    'state' => $this->getState($vehicle->state->id)
                ]);
                $this->info($vehicle->plate);
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

}
