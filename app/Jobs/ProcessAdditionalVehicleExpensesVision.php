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
            $plateRaw = $row['matricula'] ?? null;
            $plate = $plateRaw !== null && $plateRaw !== '' ? $this->splitPlate($plateRaw) : null;
            $description = $row['descripcion'] ?? null;
            $amount = $row['total'] ?? null;
            $quantity = $row['und'] ?? null;
            $unit_price = $row['precio'] ?? null;

            if (! $date || ! $description || ! $amount || ! is_numeric($amount)) {
                continue;
            }

            $vehicle_reference = ! empty(trim((string) $plateRaw)) ? ($plate ?? $plateRaw) : 'Gasto taller';
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

            $additional_vehicle_expense = AdditionalVehicleExpense::updateOrCreate(
                [
                    'fleet_id' => $this->fleet_id,
                    'date' => Date::excelToDateTimeObject($date),
                    'vehicle_reference' => $vehicle_reference,
                    'description' => $description,
                ],
                [
                    'amount' => (float) $amount,
                    'quantity' => (int) ($quantity ?? 0),
                    'unit_price' => (float) ($unit_price ?? 0),
                    'location_id' => $locationId,
                    'is_workshop' => $isWorkshop,
                    'vehicle_id' => $vehicle?->id,
                ]
            );
        }
    }

    private function splitPlate($plate): ?string
    {
        if ($plate === null || $plate === '') {
            return null;
        }
        $parts = explode(' - ', (string) $plate);

        return isset($parts[1]) ? trim($parts[1]) : trim((string) $plate);
    }
}
