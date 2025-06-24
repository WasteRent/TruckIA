<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAdditionalVehicleExpensesUteRmVao implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id, private int $customer_id) {}

    public function collection(Collection $rows)
    {
       
    }
}