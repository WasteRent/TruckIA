<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehiclesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Vehicle::filter($this->request->toArray())
            ->allowForUser()
            ->where('fleet_id', Auth::user()->fleet->id)
            ->with('equipments')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Categoría', 'ID Interno', 'Matricula', 'Bastidor / Nº serie', 'Estado', 'Marca', 'Modelo',
            'Den. Comercial', 'Tipo', 'Fecha matriculación', 'Fecha garantía', 'Fecha próxima ITV',
            'Fecha próximo tacografo', 'Kms', 'Horas CAN', 'Horas TDF', 'Cilindrada cm3', 'Potencia kw', 'Euro',
            'Combustible', 'Cliente', 'Nº Ejes', 'Ancho mm', 'Alto mm', 'Longitud mm', 'Tara kg',
            'MMA kg', 'Tipo Cambio', 'Cambio Marca', 'Cambio Modelo', 'Cambio nº serie', 'ITV Exento', 'Tacografo', 'Tacografo Exento', 'Ubicación'
        ];
    }

    public function map($vehicle): array
    {
        $rows = [
            [
                'Chasis',
                $vehicle->internal_id,
                $vehicle->plate,
                $vehicle->vin,
                $vehicle->state?->name,
                $vehicle->chassisMaker?->name,
                $vehicle->chassisModel?->name,
                $vehicle->chassisVersion?->name,
                optional($vehicle->type)->name,
                $vehicle->registration_date,
                $vehicle->warranty_date,
                $vehicle->itv_date,
                $vehicle->tachograph_date,
                $vehicle->kms,
                $vehicle->chassis_can_work_hours,
                $vehicle->equipment_work_hours,
                $vehicle->cc3,
                $vehicle->power_kw,
                $vehicle->euro,
                $vehicle->fuel,
                $vehicle->customer?->name,
                $vehicle->number_of_axes,
                $vehicle->width,
                $vehicle->height,
                $vehicle->length,
                $vehicle->tare_kg,
                $vehicle->mma_kg,
                $vehicle->gearbox_type,
                $vehicle->gearbox_maker,
                $vehicle->gearbox_model,
                $vehicle->gearbox_serial_number,
                $vehicle->itv_exempt ? 'Si':'No',
                $vehicle->tachograph ? 'Si':'No',
                $vehicle->tachograph_exempt ? 'Si':'No',
                $vehicle->location?->name,
            ]
        ];

        foreach ($vehicle->equipments as $equipment) {
            $rows[] = [
                'Equipo',
                $vehicle->internal_id,
                $vehicle->plate,
                $equipment->plate,
                $vehicle->state?->name,
                $equipment->maker?->name,
                $equipment->model?->name,
                '',
                $equipment->type,
            ];
        }

        return $rows;
    }
}
