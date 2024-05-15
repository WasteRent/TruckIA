<?php

namespace App\Imports;

use DateTime;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\Version;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\VehicleType;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FleetVehicleImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $category = $row['categoria'] ?? null;
        if ($category === 'Chasis') {
            $vehicle = Vehicle::create([
                'internal_id' => (string) $row['id_interno'],
                'plate' => $row['matricula'],
                'vin' => $row['bastidor_no_serie'],
                'chassis_maker_id' => (int) Manufacturer::where('name', $row['marca'])->first()?->id,
                'chassis_model_id' => (int) Model::where('name', $row['modelo'])->first()?->id,
                'chassis_version_id' => (int) Version::where('name', $row['den_comercial'])->first()?->id,
                'vehicle_type_id' => (int) VehicleType::where('name', $row['tipo'])->first()?->id,
                'registration_date' => $row['fecha_matriculacion'] != '' ? Date::excelToDateTimeObject($row['fecha_matriculacion'])->format('Y-m-d') : null,
                'warranty_date' => $row['fecha_garantia'] != '' ? Date::excelToDateTimeObject($row['fecha_garantia'])->format('Y-m-d') : null,
                'itv_date' => $row['fecha_proxima_itv'] != '' ? Date::excelToDateTimeObject($row['fecha_proxima_itv'])->format('Y-m-d') : null,
                'tachograph_date' => $row['fecha_proximo_tacografo'] != '' ? Date::excelToDateTimeObject($row['fecha_proximo_tacografo'])->format('Y-m-d') : null,
                'kms' => (int) $row['kms'],
                'chassis_can_work_hours' => $row['horas'],
                'cc3' => $row['cilindrada_cm3'] != '' ? $row['cilindrada_cm3'] : null,
                'power_kw' => $row['potencia_kw'],
                'euro' => $row['euro'],
                'fuel' => $row['combustible'],
                'assigned_customer_id' => Customer::where('email1', $row['cliente'])->first()?->id,
                'number_of_axes' => (int) $row['no_ejes'],
                'width' => (int) $row['ancho_mm'] ?? $row['ancho_mm'] / 1000,
                'height' => (int) $row['alto_mm'] ?? $row['alto_mm'] / 1000,
                'length' => (int) $row['longitud_mm'] ?? $row['longitud_mm'] / 1000,
                'tare_kg' => (int) $row['tara_kg'],
                'mma_kg' => (int) $row['mma_kg'],
                'gearbox_type' => $row['tipo_cambio'],
                'gearbox_maker' => $row['cambio_marca'],
                'gearbox_model' => $row['cambio_modelo'],
                'gearbox_serial_number' => $row['cambio_no_serie'],
                'fleet_id' => (int) Auth::user()->fleet->id,
            ]);

            return $vehicle;
        } elseif ($category === 'Equipo') {
            $vehicle = Vehicle::where('internal_id', $row['id_interno'])
                ->where('plate', $row['matricula'])
                ->where('fleet_id', Auth::user()->fleet->id)
                ->first();

            if ($vehicle) {
                $equipment = Equipment::create([
                    'vehicle_id' => $vehicle->id,
                    'plate' => $row['matricula'],
                    'maker_id' => Manufacturer::where('name', $row['marca'])->first()?->id,
                    'model_id' => Model::where('name', $row['modelo'])->first()?->id,
                    'type' => $row['tipo']
                ]);

                return $equipment;
            }
        }

        return null;
    }
}
