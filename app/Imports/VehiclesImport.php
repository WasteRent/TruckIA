<?php

namespace App\Imports;

use App\Imports\FleetVehicleImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class VehiclesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new FleetVehicleImport(),
        ];
    }
}
