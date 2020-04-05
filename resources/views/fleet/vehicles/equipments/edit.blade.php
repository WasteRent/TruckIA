{!! Form::model($equipment, [
	'route' => ['fleet.vehicles.equipments.update', $vehicle, $equipment],
	'method' => 'PUT',
	'class' => 'w-full'
]) !!}	

@include('fleet.vehicles.equipments.form')

<div class="flex justify-end">
	<button class="btn-indigo">Actualizar</button>
</div>
{!! Form::close() !!}