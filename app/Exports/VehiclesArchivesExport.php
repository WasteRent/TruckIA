<?php

namespace App\Exports;

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
            ->join('vehicle_checklist_files as vf', 'v.id', '=', 'vf.vehicle_id')
            ->join('vehicle_checklist_file_types as vt', 'vf.vehicle_checklist_file_type_id', '=', 'vt.id')
            ->where('v.id', $this->request->vehicle)
            ->select('v.plate', 'vt.name', 'vf.is_checked')
            ->get()
            ->groupBy('plate');
    }

    public function headings(): array
    {
        return array_merge(['Matrícula'], $this->fileTypes);
    }

    public function map($vehicle): array
    {
        $plate = $vehicle->first()->plate;
        $fileData = $vehicle->pluck('is_checked', 'name')->toArray(); 

        $mappedData = [$plate];
        foreach ($this->fileTypes as $type) {
            $mappedData[] = $fileData[$type] ? 'Sí' : 'No';
        }

        return $mappedData;
    }
}
