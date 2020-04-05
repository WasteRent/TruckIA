@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_equipments' => true])

	@component('components.card')
		@slot('title', 'Añadir equipo')
		@include('fleet.vehicles.equipments.create')
	@endcomponent

	<br><br>

	@foreach($vehicle->equipments as $equipment)
		@component('components.card')
			@slot('title', 'Equipo ' . ($loop->index + 1))

			@slot('corner')
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.equipments.destroy', [$vehicle, $equipment]) }}">
					@csrf
					@method('DELETE')
					<button><i class="icon fas fa-trash-alt"></i></button>
				</form>
			@endslot

			@include('fleet.vehicles.equipments.edit', ['vehicle' => $vehicle, 'equipment' => $equipment])
		@endcomponent
	@endforeach
@endsection
