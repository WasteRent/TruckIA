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

class ImportVehicleStateFromOdooCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:import-state-from-odoo';

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
            $vehicle = Vehicle::where('plate', $item->MatriculaChasis)->first();
            if ($item->MatriculaChasis && $vehicle && $this->getState($item->Estado) && $vehicle->state_id != $this->getState($item->Estado)) {
                $vehicle->changeState($this->getState($item->Estado));
                $this->info($vehicle->plate);
            }
        }
    }

    private function getState(string $id) {
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
            'callof' => VehicleState::CALLOFF,
            'pdi' => VehicleState::PDI,
        ];

        return isset($states[$id]) ? $states[$id] : null;
    }

}
