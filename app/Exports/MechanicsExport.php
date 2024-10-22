<?php

namespace App\Exports;

use App\Models\RepairOrder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MechanicsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
       
    }

    public function collection()
    {
         $mechanics= RepairOrder::filter($this->request->toArray())
        ->get();
        return $mechanics;
    }

    public function headings(): array
    {
        return [
            'ID Orden de reparación', 'Mecánico', 'Tiempo invertido', 'Vehículo', 'Taller'
        ];
    }

    public function map($mechanic): array
    {
        $rows = [
            [
                $mechanic->id,
                $mechanic->getAssignedUsers()?->pluck('name')->join(', '),
                number_format($mechanic->operations->sum('real_time_in_hours'), 2, ',', '.'),
                optional($mechanic->vehicle)->plate,
                optional($mechanic->garage)->name,
            ]
        ];

        

        return $rows;
    }
}
