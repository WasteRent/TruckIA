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

class ProcessAdditionalVehicleExpensesCentroGalicia implements ShouldQueue
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
            $plate = $row['matricula'] ?? null;
            $description = $row['producto'] ?? null;
            $amount = $row['precio'] ?? null;
            $supplier = $row['proveedor'] ?? null;

            if (! $date || ! $description || ! $amount || ! is_numeric($amount)) {
                continue;
            }
            dd($plate);

            $vehicle_reference = ! empty(trim((string) $plate)) ? $plate : 'Gasto taller';
            $vehicle = null;
            if (! empty(trim((string) $plate))) {
                $vehicle = Vehicle::where('fleet_id', $this->fleet_id)
                    ->where(function ($q) use ($plate) {
                        $q->where('plate', $plate)->orWhere('internal_id', $plate);
                    })
                    ->first();
            }

            $locationId = $vehicle?->location_id ?? null;
            $isWorkshop = $vehicle === null;

            AdditionalVehicleExpense::updateOrCreate(
                [
                    'fleet_id' => $this->fleet_id,
                    'date' => Date::excelToDateTimeObject($date),
                    'vehicle_reference' => $vehicle_reference,
                    'description' => $description,
                ],
                [
                    'amount' => (float) $amount,
                    'supplier' => $supplier,
                    'location_id' => $locationId,
                    'is_workshop' => $isWorkshop,
                    'vehicle_id' => $vehicle?->id,
                ]
            );
        }
    }
}
