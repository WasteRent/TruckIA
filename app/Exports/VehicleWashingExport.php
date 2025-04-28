<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\VehicleWashingType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleWashingExport implements FromCollection, WithHeadings
{
    protected $washingTypes;

    public function __construct()
    {
        $this->washingTypes = VehicleWashingType::orderBy('name')->get();
    }
    
    public function collection()
    {
        $vehicles = Vehicle::allowForUser()
            ->whereHas('washings')
            ->with([
                'washings.vehicleWashingChecklists.vehicleWashingType',
                'chassisMaker',
                'chassisModel',
                'location'
            ])
            ->get();

        $data = new Collection();

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->washings as $washing) {
                $data->push($this->map($vehicle, $washing));
            }
        }

        return $data;
    }

    public function headings(): array
    {
        $washingTypeHeaders = $this->washingTypes->pluck('name')->toArray();

        return array_merge(
            ['Matrícula'],
            ['Bastidor'],
            ['Marca'],
            ['Modelo'],
            ['Ubicación'],
            $washingTypeHeaders,
            ['Inicio'],
            ['Fin'],
            ['Tiempo Total']
        );
    }

    protected function map($vehicle, $washing = null): array
    {
        $plate = $vehicle->plate;
        $vin = $vehicle->vin;
        $chassisMaker = $vehicle->chassisMaker?->name ?? 'No disponible';
        $chassisModel = $vehicle->chassisModel?->name ?? 'No disponible';
        $location = $vehicle->location?->name ?? 'No disponible';
        $startDate = Carbon::parse($washing->start_date)->format('d/m/Y H:i');
        $endDate = Carbon::parse($washing->end_date)->format('d/m/Y H:i');
        $duration = Carbon::parse($washing->start_date)->diffInMinutes($washing->end_date) . ' minutos';

        $washingResults = [];
        
        foreach ($this->washingTypes as $type) {
            if ($washing) {
                $checklist = $washing->vehicleWashingChecklists->firstWhere('vehicle_washing_type_id', $type->id);
                $washingResults[] = $checklist && $checklist->is_checked ? 'Sí' : 'No';
            }
        }

        return array_merge(
            [$plate],
            [$vin],
            [$chassisMaker],
            [$chassisModel],
            [$location],
            $washingResults,
            [$startDate],
            [$endDate],
            [$duration]
        );
    }
}
