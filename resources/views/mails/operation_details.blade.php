@component('mail::message')
# Solicitud de mantenimiento
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

@component('mail::button', ['url' => route('garage.operations.show', $operation)])
Ver detalles
@endcomponent

## Vehículo
<ul>
	<li><strong>Matrícula:</strong> {{$operation->vehicle->plate}}</li>
	<li><strong>Chasis:</strong> {{$operation->vehicle->chassis}}</li>
	<li><strong>Caja:</strong> {{$operation->vehicle->box}}</li>
	<li><strong>Kms:</strong> {{$operation->vehicle->kms}}</li>
	<li><strong>Matriculación:</strong> {{$operation->vehicle->registration_date->format('d/m/Y')}}</li>
</ul>

@if($operation->remarks)
## Observaciones
{{ $operation->remarks }}
@endif

## Plan de mantenimiento

@component('mail::table')
| Tipo          | Aceptación | Aceptación |
| ------------- | ------------- | ------------- |
@foreach($operation->maintenance_plan->operations as $operation)
	| {{$operation->type->name}} | {{$operation->name}} | {{$operation->acceptance}} 	|
@endforeach
@endcomponent

Un saludo,<br>

@endcomponent
