@component('mail::message')

## Vehículo
<ul>
	<li><strong>Matrícula:</strong> {{$order->vehicle->plate}}</li>
	<li><strong>Chasis:</strong> {{$order->vehicle->chassis}}</li>
	<li><strong>Caja:</strong> {{$order->vehicle->box}}</li>
	<li><strong>Kms:</strong> {{$order->vehicle->kms}}</li>
	@if($order->vehicle->registration_date)
	<li><strong>Matriculación:</strong> {{Carbon\Carbon::parse($order->vehicle->registration_date)->format('d/m/Y')}}</li>
	@endif
</ul>

@component('mail::button', ['url' => route('fleet.repair-orders.show', $order)])
Acceder a O.R.
@endcomponent


## Observaciones
{{ $order->remarks }}

## Operaciones

@foreach($order->operations->groupBy('maintenance_plan_id') as $plan_ops)
#### {{ $plan_ops->first()->maintenance_plan_name }}
<ul>
@foreach($plan_ops as $operation)
	<li>{{ $operation->operation_name }}</li>
@endforeach
</ul>

@endforeach


@endcomponent
