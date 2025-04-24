<?php

namespace App\Exports;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleWashingExport implements FromCollection, WithHeadings
{
    
    public function collection(): Collection
    {
        $rows = [];
        
        $vehicles = Vehicle::allowForUser()
            ->whereHas('washings')
            ->with(['washings', 'chassisMaker', 'chassisModel', 'location'])
            ->get();

        foreach ($vehicles as $vehicle) {
            foreach ($vehicle->washings as $washing) {
                $rows[] = [
                    $vehicle->plate,
                    $vehicle->vin,
                    $vehicle->chassisMaker?->name ?? 'No disponible',
                    $vehicle->chassisModel?->name ?? 'No disponible',
                    $vehicle->location?->name ?? 'No disponible',
                    Carbon::parse($washing->start_date)->format('d/m/Y H:i'),
                    Carbon::parse($washing->end_date)->format('d/m/Y H:i'),
                    Carbon::parse($washing->start_date)->diffInMinutes($washing->end_date) . ' minutos',
                ];
            }
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Matricula', 'Bastidor', 'Marca', 'Modelo', 'Ubicación', 'Inicio', 'Fin', 'Tiempo Total'];
    }
}
