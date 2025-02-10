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
            $date = $row['fecha'] ?? null;
            $vehicle_reference = $row['referencia_del_vehiculo'] ?? null;
            $description = $row['descripcion'] ?? null;
            $amount_raw = $row['monto_euro'] ?? null;

            if ($amount_raw) {
                $amount_raw = preg_replace('/\.(?=\d{3}(?:,|$))/', '', $amount_raw);
                $amount = str_replace(',', '.', $amount_raw);
            }

            if ($date && $vehicle_reference && $description && $amount_raw && is_numeric($amount)) {
                AdditionalVehicleExpense::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'date' => Carbon::createFromFormat('d-m-y', $date)->format('Y-m-d'),
                        'vehicle_reference' => $vehicle_reference,
                        'description' => $description,
                    ],
                    [
                        'amount' => (float) $amount,
                    ]
                );
            }
        }
    }
}
