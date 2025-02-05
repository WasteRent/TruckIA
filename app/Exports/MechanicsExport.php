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
        $mechanic_hours = $mechanic->operations->flatMap->repairOrderOperationHistories
        ->groupBy('user_id');
    
        if ($mechanic_hours->count() > 1) {
            $hours = $mechanic_hours
                ->map(function ($histories, $userId) {
                    $mechanicName = User::find($userId)?->name ?? 'Mecánico desconocido';
                    $totalHours = number_format($histories->sum('hours_spent'), 2, ',', '.');
                    return "{$mechanicName} = {$totalHours} horas";
                })
                ->values()
                ->join("\n"); 
        } else {
            $hours = number_format($mechanic->operations->sum('real_time_in_hours'), 2, ',', '.') . ' horas';
        }
        
        $rows = [
            [
                $mechanic->id,
                $mechanic->getAssignedUsers()?->pluck('name')->join(', '),
                $hours, 
                optional($mechanic->vehicle)->plate,
                optional($mechanic->garage)->name,
            ]
        ];
        

        return $rows;
    }
}
