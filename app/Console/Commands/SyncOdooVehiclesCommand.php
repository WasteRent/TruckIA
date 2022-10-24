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
        $filepath = storage_path('app/data.json');
        //$client->batchAction('product.template', 'pnt_get_json_data', [], $filepath);

        $reader = new OdooReader($filepath);

        foreach ($reader->iterate() as $item) {
            unset($item->Image01);
            unset($item->Image02);
            unset($item->Image03);

            if ($item->FechaCreacion > "2022-10-10") {
                //dd($item);
                DB::beginTransaction();

                $manufacturer = Manufacturer::where('name', $item->MarcaChasisNombre)->firstOrFail();
                $model = $manufacturer->models()->where('name', '')->firstOrFail();

                $vehicle = Vehicle::create([
                    'fleet_id' => OdooCompany::SIVU,
                    'chassis_maker_id' => $manufacturer->id,
                    'chassis_model_id' => '',
                    'state_id' => $this->getStateId($item->Estado),
                    'plate' => $item->MatriculaChasis,
                    'manufacturing_date' => $item->FechaFabricacion,
                    'fuel' => $item->CombustibleNombre,
                    'power_kw' => $item->KW,
                    'cc3' => $item->Cilindrada,
                    'mma_kg' => $item->MMA,
                    'tare_kg' => $item->Tara,
                    'euro' => $item->NormativaEuroNombre,
                ]);

                DB::commit();
            }

            // if ($item->PropietarioId == OdooCompany::SIVU && $item->MatriculaChasis) {
            //     $vehicle = Vehicle::where('plate', $item->MatriculaChasis)->first();
            //     $odoo_state_id = $this->getStateId($item->Estado);

            //     if ($vehicle && $odoo_state_id && $vehicle->state_id != $odoo_state_id) {
            //         $vehicle->changeState($odoo_state_id);
            //         $this->info("Odoo: {$vehicle->plate} cambio de estado de trucki:{$vehicle->state_id} a odoo:{$odoo_state_id}");
            //         Log::info("Odoo:     {$vehicle->plate} cambio de estado de trucki:{$vehicle->state_id} a odoo:{$odoo_state_id}");
            //     }
            // }
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
