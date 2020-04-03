{!! Form::model($equipment, [
	'route' => ['admin.vehicles.equipments.update', $vehicle, $equipment],
	'method' => 'PUT',
	'class' => 'w-full'
]) !!}	

@include('admin.vehicles.equipments.form')

<div class="flex justify-end">
	<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Actualizar</button>
</div>
{!! Form::close() !!}