<?php

namespace App\Exports;

use App\Models\RepairOrder;
use App\User;
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
        return RepairOrder::filter($this->request->toArray())->get();
    }

    public function headings(): array
    {
        return [
            'Orden', 'Mecánico', 'Tiempo'
        ];
    }

    public function map($mechanic): array
    {
        $mechanic_hours = $mechanic->operations->flatMap->repairOrderOperationHistories
            ->groupBy('user_id');

        $rows = [];

        if ($mechanic_hours->count() > 0) {
            foreach ($mechanic_hours as $userId => $histories) {
                $mechanic_name = User::find($userId)?->name ?? 'Mecánico desconocido';
                $total_hours = number_format($histories->sum('hours_spent'), 2, ',', '.');

                $rows[] = [
                    $mechanic->id, 
                    $mechanic_name, 
                    $total_hours, 
                ];
            }
        }

        return $rows;
    }
}