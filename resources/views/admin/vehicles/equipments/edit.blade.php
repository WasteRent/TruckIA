{!! Form::model($equipment, [
	'route' => ['admin.vehicles.equipments.update', $vehicle, $equipment],
	'method' => 'PUT',
	'class' => 'w-full'
]) !!}	

@include('admin.vehicles.equipments.form')

<div class="flex justify-end">
	<button class="btn-indigo">Actualizar</button>
</div>
{!! Form::close() !!}