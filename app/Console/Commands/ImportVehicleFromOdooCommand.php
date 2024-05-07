<?php

namespace App\Console\Commands;

use App\Classes\AlertService;
use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use App\Models\AlertType;
use App\Models\Equipment;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\Models\VehicleType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportVehicleFromOdooCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:import-from-odoo';

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
            if ($item->PropietarioId == OdooCompany::WASTERENT && ! Vehicle::whereIn('fleet_id', [1, 6])->where('plate', $item->MatriculaChasis)->exists()) {
                DB::beginTransaction();

                try {
                    $data = $this->getChassisData($item);

                    $vehicle = Vehicle::create($data);

                    foreach ($item->Componentes as $component) {
                        if (in_array($component->Tipo, ['washdown_tank', 'chassis'])) {
                            continue;
                        }
                        $equiment_data = $this->getEquipmentData($component);
                        $equiment_data['vehicle_id'] = $vehicle->id;
                        Equipment::create($equiment_data);
                    }

                    (new AlertService)->to($vehicle->fleet)->forVehicle($vehicle)->notify(
                        'Vehículo importado desde Odoo',
                        $item->Nombre,
                        "/fleet/vehicles/{$vehicle->id}",
                        AlertType::VEHICLE_CREATED
                    );

                    $this->info($item->Nombre);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
        }
    }

    private function getEquipmentData(object $component)
    {
        $equipment_maker_id = Manufacturer::where('name', 'like', "%{$component->MarcaNombre}%")->first()?->id;
        $equipment_model_id = $equipment_maker_id ? Manufacturer::find($equipment_maker_id)->models()->where('name', 'like', "%{$component->ModeloNombre}%")->first()?->id : null;

        return [
            'plate' => $component->NumSerie,
            'type' => $component->Tipo,
            'maker_id' => $equipment_maker_id,
            'model_id' => $equipment_model_id,
            'version' => $component->DenComercialVersion,
        ];
    }

    private function getChassisData(object $item)
    {
        $chassis_maker_id = null;
        $chassis_model_id = null;
        $chassis_version_id = null;

        foreach ($item->Componentes as $component) {
            if (in_array($component->Tipo, ['washdown_tank', 'chassis'])) {
                $chassis_maker_id = Manufacturer::where('name', 'like', "%{$component->MarcaNombre}%")->first()?->id;
                $chassis_model_id = $chassis_maker_id ? Manufacturer::find($chassis_maker_id)->models()->where('name', 'like', "%{$component->ModeloNombre}%")->first()?->id : null;
                $chassis_version_id = $chassis_model_id ? Model::find($chassis_model_id)->versions()->where('name', 'like', "%{$component->DenComercialVersion}%")->first()?->id : null;
            }
        }

        return [
            'fleet_id' => 1,
            'chassis_maker_id' => $chassis_maker_id,
            'chassis_model_id' => $chassis_model_id,
            'chassis_version_id' => $chassis_version_id,
            'vehicle_type_id' => VehicleType::where('name', 'like', '%'.substr($item->TipoVehiculoNombre, 0, 15).'%')->first()?->id,
            'vin' => $item->Bastidor,
            'state_id' => $this->getState($item->Estado),
            'plate' => $item->MatriculaChasis,
            'manufacturing_date' => $item->FechaFabricacion ? $item->FechaFabricacion : null,
            'fuel' => $this->getFuel($item->CombustibleNombre),
            'cc3' => $item->Cilindrada,
            'power_kw' => $item->KW,
            'number_of_axes' => $item->NumEjes,
            'axe_1_2_distance' => $item->Distancia12,
            'axe_2_3_distance' => $item->Distancia34,
            'width' => $item->Ancho,
            'height' => $item->Alto,
            'length' => $item->Longitud,
            'tare_kg' => $item->Tara,
            'mma_kg' => $item->MMA,
            'euro' => $this->getEuro($item->NormativaEuroNombre),
            'tachograph_exempt' => $item->TacografoExento == 'y',
            'tachograph' => $item->Tacografo == 'y',
            'itv_exempt' => $item->ItvExento == 'y',
            'purchase_date' => $item->FechaCompra ? $item->FechaCompra : null,
            'itv_date' => $item->FechaProxItv ? $item->FechaProxItv : null,
            'warranty_date' => $item->FechaFinGarantiaProv ? $item->FechaFinGarantiaProv : null,
        ];
    }

    private function getEuro(string $id)
    {
        $euro = [
            'EuroII' => 'EuroII',
            'EuroIII' => 'EuroIII',
            'EuroIV' => 'EuroIV',
            'EuroV' => 'EuroV',
            'EuroV A' => 'EuroV',
            'EuroV B' => 'EuroV',
            'EuroVI' => 'EuroVI',
            'EuroVI A' => 'EuroVI',
            'EuroVI B' => 'EuroVI',
            'EuroVI C' => 'EuroVI',
            'EuroVI D' => 'EuroVI',
            'EuroVI E' => 'EuroVI',
        ];

        return isset($euro[$id]) ? $euro[$id] : null;
    }

    private function getFuel(string $id)
    {
        $fuel = [
            'Diesel' => 'Diesel',
            'Gasolina' => 'Petrol',
            'Gas' => 'Gas',
            'Eléctrico' => 'Electric',
        ];

        return isset($fuel[$id]) ? $fuel[$id] : null;
    }

    private function getState(string $id)
    {
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
