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

class ProcessAdditionalVehicleExpenses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Collection $rows, private int $fleet_id, private int $customer_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->rows as $row) {
            $date = $row['fecha'] ?? null;
            $internal_id = $row['novehiculo'] ?? null;
            $description = $row['concepto'] ?? null;
            $supplier = $row['proveedor'] ?? null;
            $quantity = $row['cantidad'] ?? null;
            $unit_price = $row['precio'] ?? null;
            $vehicle_reference = $row['matricula'] ?? 'ALMACEN/TALLER';
            $amount = $unit_price * $quantity ?? null;

            
            if ($date && $internal_id && $description && $amount && is_numeric($amount)) {
                $additional_vehicle_expense = AdditionalVehicleExpense::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'date' => Date::excelToDateTimeObject($date),
                        'description' => $description,
                        'vehicle_reference' => $vehicle_reference,  

                    ],
                    [
                        'amount' => (float) $amount,
                        'supplier' => $supplier,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'customer_id' => $this->customer_id,
                    ]
                );

                $vehicle = Vehicle::where('internal_id', $internal_id)->first();
                if ($vehicle) {
                    $additional_vehicle_expense->vehicle_id = $vehicle->id;
                    $additional_vehicle_expense->save();
                }
            }
        }
    }
}
