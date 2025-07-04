<?php

namespace App\Imports;

use App\Jobs\ProcessAdditionalVehicleExpenses;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAdditionalVehicleExpenses implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    public function __construct(private int $fleet_id, private int $customer_id)
    {
    }

    public function collection(Collection $rows)
    {
        
    }
}
