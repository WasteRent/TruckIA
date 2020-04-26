@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_equipments' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', 'Añadir equipo')
		@include('fleet.vehicles.equipments.create')
	@endcomponent

	<br><br>

	@foreach($vehicle->equipments as $equipment)
		@component('components.card')
			@slot('title', 'Equipo ' . ($loop->index + 1))

			@slot('corner')
				<div class="flex items-center">
					<a href="{{ route('fleet.vehicles.equipments.edit', [$vehicle, $equipment]) }}" class="btn-outline-gray mr-5">Editar</a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.equipments.destroy', [$vehicle, $equipment]) }}">
						@csrf
						@method('DELETE')
						<button class="btn-outline-red">Eliminar</button>
					</form>
				</div>
			@endslot

			<div class="flex">
				<div class="w-1/2">
					@component('components.table')
						@slot('items', [
							'Tipo' => $equipment->type,
							'Núm. Equipo' => $equipment->plate,
							'Marca' => $equipment->maker->name,
							'Modelo' => $equipment->model->name,
							'Version' => $equipment->version,
							'Garantía' => $equipment->warranty_date
						])
					@endcomponent

					@if($equipment->bomb_maker)
					<fieldset>
					  <legend>Bomba</legend>
					  @component('components.table')
					  	@slot('items', [
					  		'Número de Serie' => $equipment->bomb_serial_number,
					  		'Marca' => $equipment->bomb_maker,
					  		'Modelo' => $equipment->bomb_model
					  	])
					  @endcomponent
					</fieldset>
					@endif
				</div>
				<div class="w-1/2">
					@if($equipment->picture)
						<a href="{{ $equipment->picture->getLink() }}" target="_blank">
							<img class="w-64" src="{{ $equipment->picture->getLink() }}">
						</a>
					@else
						<i class="fas fa-image text-gray-300" style="font-size: 12rem;"></i>
					@endif
				</div>
			</div>


		@endcomponent
	@endforeach
@endsection
