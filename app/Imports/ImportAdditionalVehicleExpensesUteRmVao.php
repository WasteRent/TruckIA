<?php

namespace App\Imports;

use App\Models\AdditionalVehicleExpense;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportAdditionalVehicleExpensesUteRmVao implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id, private int $customer_id)
    {
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $date = $row['fecha'] ?? null;
            $plate = $row['matricula'] ?? null;
            $description = $row['descripcion'] ?? null;
            $amount = $row['coste'] ?? null;
            $supplier = $row['proveedor'] ?? null;

            if ($date && $plate && $description && $amount && is_numeric($amount) && $supplier) {
                
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
                        'supplier' => $supplier,
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
}