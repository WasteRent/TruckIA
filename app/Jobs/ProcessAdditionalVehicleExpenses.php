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
    public function __construct(private int $fleet_id, private int $customer_id, public Collection $rows)
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
            $vehicle_reference = $row['referencia_del_vehiculo'] ?? null;
            $description = $row['descripcion'] ?? null;
            $amount_raw = $row['monto_euro'] ?? null;

            
            if ($amount_raw) {
                $amount_raw = preg_replace('/\.(?=\d{3}(?:,|$))/', '', $amount_raw);
                $amount = str_replace(',', '.', $amount_raw);
            }

            if ($date && $vehicle_reference && $description && $amount_raw && is_numeric($amount)) {
                $additional_vehicle_expense = AdditionalVehicleExpense::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'date' => Date::excelToDateTimeObject($date),
                        'vehicle_reference' => $vehicle_reference,
                        'description' => $description,
                        'customer_id' => $this->customer_id,
                    ],
                    [
                        'amount' => (float) $amount,
                    ]
                );

                $vehicle = Vehicle::where('plate', $vehicle_reference)->orWhere('internal_id', $vehicle_reference)->allowForUser()->first();
                if ($vehicle) {
                    $additional_vehicle_expense->vehicle_id = $vehicle->id;
                    $additional_vehicle_expense->save();
                }
            }
        }
    }
}
