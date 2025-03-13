@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_equipments' => true])

	@component('components.card', ['compressed' => true])
		@slot('title', __('Añadir equipo'))
		@include('fleet.vehicles.equipments.create')
	@endcomponent

	<br><br>

	@foreach($vehicle->equipments as $equipment)
		@component('components.card')
			@slot('title', __('Equipo') .' '. ($loop->index + 1))
			@if(!in_array(Auth::user()->job, ['garage_boss', 'garage', 'mechanic']) || Auth::user()->fleet->id != App\Models\Fleet::ACCIONA)
			@slot('corner')
				<div class="flex items-center">
					<a href="{{ route('fleet.vehicles.equipments.edit', [$vehicle, $equipment]) }}" class="btn-outline-gray mr-5">{{ __('Editar') }}</a>
					<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.equipments.destroy', [$vehicle, $equipment]) }}">
						@csrf
						@method('DELETE')
						<button class="btn-outline-red">{{ __('Eliminar') }}</button>
					</form>
				</div>
			@endslot
			@endif

			<div class="sm:flex">
				<div class="sm:w-1/2">
					@component('components.table')
						@slot('items', [
							__('Tipo') => $equipment->type,
							__('Núm. Equipo') => $equipment->plate,
							__('Marca') => $equipment->maker?->name,
							__('Modelo') => $equipment->model?->name,
							__('Version') => $equipment->version,
							__('Garantía') => $equipment->warranty_date ? Carbon\Carbon::parse($equipment->warranty_date)->format('d/m/Y'):null,
							__('Fecha de Fabricación') => $equipment->manufacturing_date ? Carbon\Carbon::parse($equipment->manufacturing_date)->format('d/m/Y'):null
						])
					@endcomponent

					@if($equipment->bomb_maker)
					<fieldset>
					  <legend>{{ __('Bomba') }}</legend>
					  @component('components.table')
					  	@slot('items', [
					  		__('Número de serie') => $equipment->bomb_serial_number,
					  		__('Marca') => $equipment->bomb_maker,
					  		__('Modelo') => $equipment->bomb_model
					  	])
					  @endcomponent
					</fieldset>
					@endif
				</div>
				<div class="sm:w-1/2 mt-4 sm:mt-0">
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
