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

class ProcessAdditionalVehicleExpensesVision implements ShouldQueue
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
                    $vehicle = Vehicle::where('plate', $plate)->orWhere('internal_id', $plate)->first();
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
