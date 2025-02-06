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

        return Vehicle::filter($this->request->all())->allowForUser()->get();
    }

    public function headings(): array
    {
        return array_merge(['Matrícula'], ["Ubicación"], $this->fileTypes);
    }

    public function map($vehicle): array
    {
        $plate = $vehicle->plate;
        $location = $vehicle->location->name ?? '';

        $fileData = [];

        foreach ($this->fileTypes as $type) {
            $fileData[$type] = 'No';
        }

        foreach ($vehicle->checklistFiles as $vehicleChecklistFile) {
            $fileData[$vehicleChecklistFile->fileType->name] = $vehicleChecklistFile->is_checked ? 'Sí' : 'No';
        }

        return array_merge([$plate], [$location], array_values($fileData));
    }
}
