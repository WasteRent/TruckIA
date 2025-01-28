<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesArchivesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
       
    }

    public function collection()
    {
        return Vehicle::where('id', $this->request->vehicle)->get();
    }

    public function headings(): array
    {
        return [
            'Matrícula', 'Ficha técnica', 'Permiso de circulación', 'Manual de equipo',
        ];
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->plate,
            $vehicle->vehicleChecklistFiles->technical_sheet ? 'Sí' : 'No',
            $vehicle->vehicleChecklistFiles->vehicle_registration ? 'Sí' : 'No',
            $vehicle->vehicleChecklistFiles->equipment_manual ? 'Sí' : 'No',
        ];
    }
}
