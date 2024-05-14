<?php

namespace App\Http\Controllers\Fleet;

use DateTime;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\Version;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\VehicleType;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FleetImportVehicleController extends Controller
{
    public function create()
    {
        return view('fleet.vehicles.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:csv,txt',
        ]);

        $file = fopen($request->file('attachment')->getRealPath(), 'r');
        $header = fgets($file);
        fclose($file);

        $separators = [',', ';', '\t', '|'];
        $separator = $this->detectSeparator($header, $separators);


        DB::beginTransaction();

        try {
            $file = fopen($request->file('attachment')->getRealPath(), 'r');
            $header = fgetcsv($file, 0, $separator);

            while (($row = fgetcsv($file, 0, $separator)) !== false) {
                $category = $row[0];

                if ($category === 'chasis') {
                    $vehicleData = [
                        'internal_id' => (int) $row[1],
                        'plate' => $row[2],
                        'vin' => $row[3],
                        'chassis_maker_id' => (int) Manufacturer::where('name', $row[4])->first()?->id,
                        'chassis_model_id' => (int) Model::where('name', $row[5])->first()?->id,
                        'chassis_version_id' => (int) Version::where('name', $row[6])->first()?->id,
                        'vehicle_type_id' => (int) VehicleType::where('name', $row[7])->first()?->id,
                        'registration_date' => $row[8] != '' ? DateTime::createFromFormat('d/m/Y', $row[8])->format('Y-m-d') : null,
                        'warranty_date' => $row[9] != '' ? DateTime::createFromFormat('d/m/Y', $row[9])->format('Y-m-d') : null,
                        'itv_date' => $row[10] != '' ? DateTime::createFromFormat('d/m/Y', $row[10])->format('Y-m-d') : null,
                        'tachograph_date' => $row[11] != '' ? DateTime::createFromFormat('d/m/Y', $row[11])->format('Y-m-d') : null,
                        'kms' => (int) $row[12],
                        'chassis_can_work_hours' => $row[13],
                        'cc3' => $row[14] != '' ? $row[11] : null,
                        'power_kw' => $row[15],
                        'euro' => $row[16],
                        'fuel' => $row[17],
                        'assigned_customer_id' => Customer::where('email1', $row[18])->first()?->id,
                        'number_of_axes' => (int) $row[19],
                        'width' => (int) $row[20] ?? $row[20] / 1000,
                        'height' => (int) $row[21] ?? $row[21] / 1000,
                        'length' => (int) $row[22] ?? $row[22] / 1000,
                        'tare_kg' => (int) $row[23],
                        'mma_kg' => (int) $row[24],
                        'gearbox_type' => $row[25],
                        'gearbox_maker' => $row[26],
                        'gearbox_model' => $row[27],
                        'gearbox_serial_number' => $row[28],
                        'fleet_id' => (int) Auth::user()->fleet->id,
                    ];

                    $vehicle = Vehicle::create($vehicleData);
                } elseif ($category === 'equipo') {

                    $vehicle = Vehicle::where('internal_id', $row[1])
                        ->where('plate', $row[2])
                        ->where('fleet_id', Auth::user()->fleet->id)
                        ->first();

                    if ($vehicle) {
                        $equipmentData = [
                            'vehicle_id' => $vehicle->id,
                            'plate' => $row[3],
                            'maker_id' => Manufacturer::where('name', $row[4])->first()?->id,
                            'model_id' => Model::where('name', $row[5])->first()?->id,
                            'type' => $row[7]
                        ];

                        Equipment::create($equipmentData);
                    }
                }
            }
            fclose($file);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


        return redirect()->route('fleet.vehicles.index')->with('success_message', 'Los vehículos y equipamientos se han importado correctamente.');
    }

    private function detectSeparator($header, $separators)
    {
        foreach ($separators as $separator) {
            if (count(str_getcsv($header, $separator)) > 1) {
                return $separator;
            }
        }
        throw new \Exception('No se pudo detectar el separador del archivo CSV');
    }
}
