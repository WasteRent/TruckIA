@extends('box.layout')

@section('content')
	@component('components.card', [])		
		@slot('title')
			<div class="flex">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
				</svg>
				<span class="font-bold">Vehículo</span>
			</div>
		@endslot


		@slot('corner')
			<a class="btn inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white transition ease-in-out duration-150" href="{{ route('fleet.vehicles.show', $vehicle) }}">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
				  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>
				Ver ficha completa
			</a>
		@endslot

		
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
	
	@component('components.card', [])
		@slot('title')
			<div class="flex">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
				</svg>
				<span class="font-bold">Horas y Kms</span>
			</div>
		@endslot

		@slot('corner')
			<a class="btn inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white transition ease-in-out duration-150" href="{{ route('fleet.vehicles.counters.index', $vehicle) }}">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
				  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>
				Ver más
			</a>
		@endslot

		<details>
		    <summary>Actualizar</summary>
		  	<div>
		  		@include('fleet.vehicles.counters.update-form')
		  	</div>
		</details>
	@endcomponent



	@component('components.card', [])
		@slot('title')
			<div class="flex">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
				</svg>
				<span class="font-bold">Incidencias</span>
			</div>
		@endslot

		@slot('corner')
			<a class="btn inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white transition ease-in-out duration-150" href="{{ route('fleet.vehicles.incidents.index', $vehicle) }}">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
				  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>
				Ver más
			</a>
		@endslot

		<details>
		    <summary>Crear incidencia</summary>
		  	@include('fleet.vehicles.incidents.create')
		</details>
	@endcomponent

@endsection