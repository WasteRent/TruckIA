<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\VehicleWashingType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleWashingChecklistExport implements FromCollection, WithHeadings
{
    protected $fileTypes;

    public function __construct()
    {
        $this->fileTypes = VehicleWashingType::pluck('name')->toArray();
    }

    public function collection()
    {
        $vehicles = Vehicle::allowForUser()
            ->whereHas('washings')
            ->with(['washings', 'chassisMaker', 'chassisModel', 'location'])
            ->get();
        
        return $vehicles->map(function ($vehicle) {
            return $this->map($vehicle);
        });
    }

    public function headings(): array
    {
        return array_merge(['Matricula'], ['Bastidor'], ['Marca'], ['Modelo'], ['Ubicación'], $this->fileTypes);
    }

    public function map($vehicle): array
    {
        $plate = $vehicle->plate;
        $vin = $vehicle->vin;
        $chassisMaker = $vehicle->chassisMaker?->name ?? 'No disponible';
        $chassisModel = $vehicle->chassisModel?->name ?? 'No disponible';
        $location = $vehicle->location?->name ?? 'No disponible';

        $washingData = [];

        foreach ($this->fileTypes as $typeName) {
            $type = VehicleWashingType::where('name', $typeName)->first();
            if ($vehicle->washings->firstWhere('vehicle_washing_type_id', $type->id)->is_checked) {
                $washingData[$typeName] = 'Sí';
            } else {
                $washingData[$typeName] = 'No';
            }
        }

        return array_merge(
            [$plate],
            [$vin],
            [$chassisMaker],
            [$chassisModel],
            [$location],
            array_values($washingData)
        );
    }
}
