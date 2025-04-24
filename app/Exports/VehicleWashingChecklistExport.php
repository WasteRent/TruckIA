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

        return Vehicle::allowForUser()
        ->whereHas('washings')
        ->with(['washings', 'chassisMaker', 'chassisModel', 'location'])
        ->get();
    }

    public function headings(): array
    {
        return array_merge(['Matricula'], ['Bastidor'], ['Marca'], ['Modelo'], ['Ubicación'], ['Inicio'], ['Fin'], ['Tiempo Total'], $this->fileTypes);
    }

    public function map($vehicles)
    {
        $rows = [];
        

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->washings as $washing) {
                foreach ($washing->vehicleWashingChecklists as $vehicleWashingChecklist) {
                    $rows[] = [
                        $vehicle->plate,
                        $vehicle->vin,
                        $vehicle->chassisMaker?->name ?? 'No disponible',
                        $vehicle->chassisModel?->name ?? 'No disponible',
                        $vehicle->location?->name ?? 'No disponible',
                        Carbon::parse($washing->start_date)->format('d/m/Y H:i'),
                        Carbon::parse($washing->end_date)->format('d/m/Y H:i'),
                        Carbon::parse($washing->start_date)->diffInMinutes($washing->end_date) . ' minutos',
                        $vehicleWashingChecklist->is_checked ? 'Sí' : 'No',
                    ];
                }
            }
        }

        return collect($rows, $this->fileTypes);
    }

}
