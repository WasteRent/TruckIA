<?php

namespace App\Exports;

use App\Models\Vehicle;
use App\Models\VehicleChecklistFile;
use App\Models\VehicleChecklistFileType;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesArchivesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;
    protected $fileTypes;

    public function __construct($request)
    {
        $this->request = $request;
        $this->fileTypes = VehicleChecklistFileType::pluck('name')->toArray();
    }

    public function collection()
    {

        return DB::table('vehicles as v')
            ->leftJoin('vehicle_checklist_files as vf', 'v.id', '=', 'vf.vehicle_id')
            ->leftJoin('vehicle_checklist_file_types as vt', 'vf.vehicle_checklist_file_type_id', '=', 'vt.id')
            ->select('v.plate', 'vt.name', 'vf.is_checked')
            ->whereNull('v.deleted_at')
            ->where('v.fleet_id', 1)
            ->get()
            ->groupBy('plate');
    }

    public function headings(): array
    {
        return array_merge(['Matrícula'], $this->fileTypes);
    }

    public function map($vehicles): array
    {
      
        $groupedVehicles = [];

        // Agrupar documentos por número de matrícula (plate)
        foreach ($vehicles as $vehicle) {
            $plate = $vehicle->plate;
            $groupedVehicles[$plate][$vehicle->name] = $vehicle->is_checked;
        }

        $result = [];

        // Crear la estructura de salida
        foreach ($groupedVehicles as $plate => $fileData) {
            $mappedData = [$plate];

            foreach ($this->fileTypes as $type) {
                $mappedData[] = isset($fileData[$type]) && $fileData[$type] ? 'Sí' : 'No';
            }

            $result[] = $mappedData;
        }

        return $result;
    }
}
