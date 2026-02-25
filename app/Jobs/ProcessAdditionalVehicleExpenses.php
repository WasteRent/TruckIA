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

    public function __construct(private Collection $rows, private int $fleet_id)
    {
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
            $plate = $row['matricula'] ?? null;
            $vehicle_reference = ! empty(trim((string) $plate)) ? $plate : 'Gasto taller';
            $amount = $unit_price * $quantity ?? null;

            if (! $date || ! $description || ! $amount || ! is_numeric($amount)) {
                continue;
            }

            $vehicle = null;
            if (! empty(trim((string) $internal_id))) {
                $vehicle = Vehicle::where('fleet_id', $this->fleet_id)
                    ->where('internal_id', $internal_id)
                    ->first();
            }
            if (! $vehicle && ! empty(trim((string) $plate))) {
                $vehicle = Vehicle::where('fleet_id', $this->fleet_id)
                    ->where(function ($q) use ($plate) {
                        $q->where('plate', $plate)->orWhere('internal_id', $plate);
                    })
                    ->first();
            }

            $locationId = $vehicle?->location_id ?? null;
            $isWorkshop = $vehicle === null;

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
                    'customer_id' => $locationId,
                    'is_workshop' => $isWorkshop,
                    'vehicle_id' => $vehicle?->id,
                ]
            );
        }
    }
}
