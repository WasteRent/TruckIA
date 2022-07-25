@extends('box.layout')

@section('content')

	@component('components.card', ['no_shadow' => true])
		@slot('title', __('Datos del vehículo'))
		
		<div class="sm:flex">
			<div class="sm:w-1/2">
				@php 
					$equipments = "";
					foreach($vehicle->equipments as $equipment){
						$equipments .= "{$equipment->type} {$equipment->maker->name} {$equipment->model->name}<br>";
					}
				@endphp

				@component('components.table')
					@slot('items', [
						__('Matrícula') => $vehicle->plate,
						__('Tipo') => optional($vehicle->type)->name,
						__('Chasis') => $vehicle->chassis,
						__('Equipo') => $equipments,
						__('Estado') => $vehicle->customer ? ($vehicle->state->name . ' - ' . $vehicle->customer->name) : optional($vehicle->state)->name,
						__('Fecha de fabricación') => $vehicle->manufacturing_date ? Carbon\Carbon::parse($vehicle->manufacturing_date)->format('d/m/Y'):null,
						__('Ubicación') => $vehicle->location,
					])
				@endcomponent
			</div>
			<div class="sm:w-1/2 mt-4 sm:mt-0">
				@if($vehicle->pictures->count() > 0)
					<img loading="lazy" src="{{ $vehicle->getCover()->getLink() }}">
				@else
					<i class="fas fa-image text-gray-300" style="font-size: 12rem;"></i>
				@endif
			</div>
		</div>
	@endcomponent

	@include('box.files')


	@include('box.incidents')

	@include('box.counters')
	
@endsection