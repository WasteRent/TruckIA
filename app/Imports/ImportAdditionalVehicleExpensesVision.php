<?php

namespace App\Imports;

use App\Jobs\ProcessAdditionalVehicleExpensesVision;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAdditionalVehicleExpensesVision implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id)
    {
    }

    public function collection(Collection $rows)
    {
        
    }
}