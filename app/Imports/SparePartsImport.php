<?php

namespace App\Imports;

use App\Classes\Helpers;
use App\Models\SparePart;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SparePartsImport implements ToCollection, WithHeadingRow
{
    public function __construct(private int $fleet_id, private int $customer_id)
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
            $safety_stock = $row['stock_de_seguridad'] ?? null;

            if ($description && $manufacturer && $reference && $price && $stock) {
               SparePart::updateOrCreate(
                    [
                        'fleet_id' => $this->fleet_id,
                        'reference' => $reference,
                        'unit_price' => $price,
                        'short_reference' => Helpers::shortReference($reference),
                    ],
                    [  
                        'description' => $description,
                        'manufacturer' => $manufacturer,
                        'stock' => (int) $stock,
                        'safety_stock' => $safety_stock,
                        'customer_id' => $this->customer_id,
                    ]
                );
            }
        }
    }
}
