<?php

namespace App\Imports;

use App\Models\SparePart;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SparePartsImport implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id)
    {
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $description = $row['descripcion'] ?? null;
            $manufacturer = $row['marca'] ?? null;
            $reference = $row['referencia'] ?? null;
            $price = $row['precio'] ?? null;
            $stock = $row['stock'] ?? null;

            if ($description && $manufacturer && $reference && $price && $stock) {
               SparePart::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'reference' => $reference,
                        'unit_price' => $price,
                    ],
                    [  
                        'description' => $description,
                        'manufacturer' => $manufacturer,
                        'stock' => (int) $stock,
                    ]
                );
            }
        }
    }
}
