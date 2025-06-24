<?php

namespace App\Jobs;

use App\Models\AdditionalVehicleExpense;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProcessAdditionalVehicleExpensesUteRmVao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Collection $rows,
        private int $fleet_id,
        private int $customer_id
    ) {}

    public function handle(): void
    {
        foreach ($this->rows as $row) {
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

                $vehicle = Vehicle::where('plate', $plate)
                    ->orWhere('internal_id', $plate)
                    ->first();

                if ($vehicle) {
                    $additional_vehicle_expense->vehicle_id = $vehicle->id;
                    $additional_vehicle_expense->save();
                }
            }
        }
    }
}