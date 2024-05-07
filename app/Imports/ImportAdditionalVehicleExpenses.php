<?php

namespace App\Imports;

use App\Models\AdditionalVehicleExpense;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAdditionalVehicleExpenses implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id)
    {
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->values();

            preg_match('!\d+\.*\d*\,*\d*!', $row[7], $amount);
            $amount = str_replace('.', '', $amount[0]);
            $amount = str_replace(',', '.', $amount);

            if ($row[0] && $row[2] && $row[3] && $row[7] && isset($amount[0]) && is_numeric($amount)) {
                AdditionalVehicleExpense::create([
                    'fleet_id' => $this->fleet_id,
                    'date' => Carbon::createFromFormat('d-m-y', $row[0])->format('Y-m-d'),
                    'vehicle_reference' => $row[2],
                    'description' => $row[3],
                    'amount' => (float) $amount,
                ]);
            }
        }
    }
}
