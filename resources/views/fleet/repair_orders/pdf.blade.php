@extends('layouts.pdf')

@section('content')
<style>
    body {
        font-family: sans-serif;
        font-size: 14px;
        color: #333;
    }
    h3 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        border-bottom: 2px solid #333;
        padding-bottom: 4px;
    }
    .section {
        margin-bottom: 24px;
    }
    .info p {
        margin: 4px 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 6px 10px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<div class="section">
    <h3>Orden de reparación</h3>
    <div class="info">
        <p><strong>Fecha de creación:</strong> {{ $repair_order->created_at->format('d-m-Y H:i:s') }}</p>
        <p><strong>Vehículo:</strong> {{ $repair_order->vehicle->plate }} · {{ $repair_order->vehicle->chassis }}<br>{{ $repair_order->vehicle->equipment }}</p>
        <p><strong>Creada por:</strong> {{ optional($repair_order->creator)->name }}</p>
        <p><strong>Asignada a:</strong> {{ $repair_order->getAssignedUsers()?->pluck('name')->join(', ') }}</p>
        @if($repair_order->related_incident_id)
            <p><strong>Incidencia asociada:</strong> #{{ $repair_order->related_incident_id }} - {{ $repair_order->relatedIncident->user->name }}</p>
        @endif
        <p><strong>Estado:</strong> {{ optional($repair_order->state)->name }}</p>
    </div>
</div>

<div class="section">
    <h3>Datos generales</h3>
    <div class="info">
        <p><strong>Mantenimiento:</strong> 
            @php
                $types = [
                    'preventive' => __('Preventivo'),
                    'corrective' => __('Correctivo'),
                    'pre-itv' => __('Pre-ITV'),
                    'weekly' => __('Semanal'),
                    'tires' => 'Neumáticos',
                    'bad_use' => 'Malos usos',
                    'support' => __('Asistencia'),
                ];
            @endphp
            {{ $types[$repair_order->type] ?? $repair_order->type }}
        </p>
        <p><strong>Fecha de apertura:</strong> {{ optional($repair_order->created_at)->format('d-m-Y') }}</p>
        <p><strong>Fecha de cita:</strong> {{ optional($repair_order->appointment)->format('d-m-Y') }}</p>
        <p><strong>KMS:</strong> {{ $repair_order->kms }}</p>
        <p><strong>Horas chasis:</strong> {{ $repair_order->work_hours_chassis }}</p>
        <p><strong>Horas equipo:</strong> {{ $repair_order->work_hours_equipment }}</p>
        @if($repair_order->internal_notes)
            <p><strong>Nota interna de OR:</strong><br>{!! nl2br(e(strip_tags($repair_order->internal_notes))) !!}</p>
        @endif
    </div>
</div>

<div class="section">
    <h3>Operaciones realizadas</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>H. reales</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($repair_order->operations as $operation)
                <tr>
                    <td>{{ $operation->description }}</td>
                    <td>{{ $operation->hours }}</td>
                    <td>{{ number_format($operation->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Sin operaciones registradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Recambios</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Referencia</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($repair_order->parts as $part)
                <tr>
                    <td>{{ $part->name }}</td>
                    <td>{{ $part->brand }}</td>
                    <td>{{ $part->reference }}</td>
                    <td>{{ $part->pivot?->quantity }}</td>
                    <td>{{ number_format($part->pivot?->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sin recambios registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection