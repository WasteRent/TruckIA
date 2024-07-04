<?php

namespace App\Imports;

use App\Models\Model;
use App\Models\Vehicle;
use App\Models\Version;
use App\Models\Customer;
use App\Models\Equipment;
use App\Models\VehicleType;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class FleetVehicleImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        $category = $row['categoria'] ?? null;

        if ($category === 'Chasis') {
            return $this->createVehicle($row);
        } elseif ($category === 'Equipo') {
            return $this->createEquipment($row);
        }

        return null;
    }

    protected function createVehicle(array $row)
    {
        return Vehicle::updateOrCreate(
            ['plate' => $row['matricula'], 'fleet_id' => Auth::user()->fleet->id],
            [
            'internal_id' => (string) $row['id_interno'],
            'plate' => $row['matricula'],
            'vin' => $row['bastidor_no_serie'],
            'chassis_maker_id' => Manufacturer::where('name', $row['marca'])->first()?->id,
            'chassis_model_id' => Model::where('name', $row['modelo'])->first()?->id,
            'chassis_version_id' => Version::where('name', $row['den_comercial'])->first()?->id,
            'vehicle_type_id' => VehicleType::where('name', $row['tipo'])->first()?->id,
            'registration_date' => $row['fecha_matriculacion'] != '' ? $row['fecha_matriculacion'] : null,
            'warranty_date' => $row['fecha_garantia'] != '' ? $row['fecha_matriculacion'] : null,
            'itv_date' => $row['fecha_proxima_itv'] != '' ? $row['fecha_matriculacion'] : null,
            'tachograph_date' => $row['fecha_proximo_tacografo'] != '' ? $row['fecha_matriculacion'] : null,
            'kms' => (int) $row['kms'],
            'chassis_can_work_hours' => $row['horas_can'] ?? 0,
            'equipment_work_hours' => $row['horas_tdf'] ?? 0,
            'cc3' => $row['cilindrada_cm3'] != '' ? $row['cilindrada_cm3'] : null,
            'power_kw' => $row['potencia_kw'],
            'euro' => $row['euro'],
            'fuel' => $row['combustible'],
            'assigned_customer_id' => Customer::where('name', $row['cliente'])->where('fleet_id', Auth::user()->fleet->id)->first()?->id,
            'number_of_axes' => (int) $row['no_ejes'],
            'width' => (float) $row['ancho_mm'],
            'height' => (float) $row['alto_mm'],
            'length' => (float) $row['longitud_mm'],
            'tare_kg' => (int) $row['tara_kg'],
            'mma_kg' => (int) $row['mma_kg'],
            'gearbox_type' => $row['tipo_cambio'],
            'gearbox_maker' => $row['cambio_marca'],
            'gearbox_model' => $row['cambio_modelo'],
            'gearbox_serial_number' => $row['cambio_no_serie'],
            'fleet_id' => (int) Auth::user()->fleet->id,
        ]);
    }

    protected function createEquipment(array $row)
    {
        $vehicle = Vehicle::where('plate', $row['matricula'])
            ->where('fleet_id', Auth::user()->fleet->id)
            ->first();

        if ($vehicle) {
            return Equipment::updateOrCreate(
                ['vehicle_id' => $vehicle->id, 'type' => $row['tipo']],
                [
                'vehicle_id' => $vehicle->id,
                'plate' => $row['matricula'],
                'maker_id' => Manufacturer::where('name', $row['marca'])->first()?->id,
                'model_id' => Model::where('name', $row['modelo'])->first()?->id,
                'type' => $row['tipo']
            ]);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            '*.categoria' => 'required',
            '*.id_interno' => 'nullable',
            '*.matricula' => 'required|string|max:255',
            '*.bastidor_no_serie' => 'nullable|string|max:255',
            '*.marca' => ['nullable', 'string', Rule::exists('manufacturers', 'name')],
            '*.modelo' => ['nullable', 'string', Rule::exists('models', 'name')],
            '*.den_comercial' => 'nullable|string|max:255',
            '*.tipo' => 'nullable|string',
            '*.fecha_matriculacion' => 'nullable|date',
            '*.fecha_garantia' => 'nullable|date',
            '*.fecha_proxima_itv' => 'nullable|date',
            '*.fecha_proximo_tacografo' => 'nullable|date',
            '*.kms' => 'nullable|integer|min:0',
            '*.horas' => 'nullable|numeric|min:0',
            '*.cilindrada_cm3' => 'nullable|integer|min:0',
            '*.potencia_kw' => 'nullable|integer|min:0',
            '*.euro' => 'nullable|string|max:255',
            '*.combustible' => 'nullable|string|max:255',
            '*.cliente' => ['nullable', 'string', Rule::exists('customers', 'name')],
            '*.no_ejes' => 'nullable|integer|min:0',
            '*.ancho_mm' => 'nullable|integer|min:0',
            '*.alto_mm' => 'nullable|integer|min:0',
            '*.longitud_mm' => 'nullable|integer|min:0',
            '*.tara_kg' => 'nullable|integer|min:0',
            '*.mma_kg' => 'nullable|integer|min:0',
            '*.tipo_cambio' => 'nullable|string|max:255',
            '*.cambio_marca' => 'nullable|string|max:255',
            '*.cambio_modelo' => 'nullable|string|max:255',
            '*.cambio_no_serie' => 'nullable|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => 'El campo :attribute es obligatorio en la fila :row.',
            '*.integer' => 'El campo :attribute debe ser un número entero en la fila :row.',
            '*.date' => 'El campo :attribute debe ser una fecha válida en la fila :row.',
            '*.string' => 'El campo :attribute debe ser una cadena de texto en la fila :row.',
            '*.exists' => 'El campo :attribute debe existir en la base de datos en la fila :row.',
            '*.max' => 'El campo :attribute no debe exceder :max caracteres en la fila :row.',
            '*.numeric' => 'El campo :attribute debe ser un número en la fila :row.',
        ];
    }
}
