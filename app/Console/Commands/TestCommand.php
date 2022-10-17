<?php

namespace App\Console\Commands;

use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Console\Command;
use \JsonMachine\Items;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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
            if ($item->PropietarioId == OdooCompany::SIVU && $item->MatriculaChasis) {
                $vehicle = Vehicle::where('plate', $item->MatriculaChasis)->first();

                if ($vehicle && $this->getState($vehicle->state_id)) {
                    $client->executeAction('product.template', 'pnt_trucki_set_data', [
                        'id' => $item->Id,
                        'state' => $this->getState($vehicle->state_id)
                    ]);

                    $this->info($vehicle->plate);
                }
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
        ];

        return isset($states[$id]) ? $states[$id] : null;
    }
}
