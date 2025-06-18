<?php

namespace App\Imports;

use App\Models\AdditionalVehicleExpense;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class ImportAdditionalVehicleExpensesVision implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id, private int $customer_id)
    {
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $date = $row['fecha'] ?? null;
            $plate = $this->splitPlate($row['matricula']) ?? null;
            $description = $row['descripcion'] ?? null;
            $amount = $row['total'] ?? null;
            $quantity = $row['und'] ?? null;
            $unit_price = $row['precio'] ?? null;

            if ($date && $plate && $description && $amount && is_numeric($amount) && $quantity && $unit_price) {               
                $additional_vehicle_expense = AdditionalVehicleExpense::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'date' => Date::excelToDateTimeObject($date),
                        'vehicle_reference' => $plate,
                        'description' => $description,
                        'customer_id' => $this->customer_id,
                    ],
                    [
                        'amount' => (float) $amount,
                        'quantity' => (int) $quantity,
                        'unit_price' => (float) $unit_price,
                    ]
                    );
                    $vehicle = Vehicle::where('plate', $plate)->orWhere('internal_id', $plate)->allowForUser()->first();
                    if ($vehicle) {
                        $additional_vehicle_expense->vehicle_id = $vehicle->id;
                        $additional_vehicle_expense->save();
                }
            }
        }
    }

    private function splitPlate($plate)
    {
        return explode(' - ', $plate)[1];
    }
}