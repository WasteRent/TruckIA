<?php

namespace App\Imports;

use App\Models\AdditionalVehicleExpense;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ImportAdditionalVehicleExpenses implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id)
    {
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->values();

            if ($row[0] && $row[2] && $row[3] && $row[7] && is_numeric(str_replace('€', '', $row[7]))) {
                AdditionalVehicleExpense::create([
                    'fleet_id' => $this->fleet_id,
                    'date' => Carbon::createFromFormat('d-m-y', $row[0])->format('Y-m-d'),
                    'vehicle_reference' => $row[2],
                    'description' => $row[3],
                    'amount' => (float) str_replace('€', '', $row[7]),
                ]);
            }
        }
    }
}
