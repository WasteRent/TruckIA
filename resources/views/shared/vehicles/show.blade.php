@component('components.card')
	@slot('title', 'Datos del vehículo')
	@slot('corner')
		<a href="{{ route('garage.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1">Crear O.R.</a>
		<a href="{{ route('garage.vehicles.index') }}" class="btn-outline-gray mb-2 float-right">Vista previa</a>
	@endslot
	
	@if(Auth::user()->hasRole('fleet'))
		@slot('corner')
			<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1">Crear O.R.</a>
			<a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn-outline-gray">Ver ficha completa</a>
		@endslot
	@endif

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
					'Matrícula' => $vehicle->plate,
					'Tipo' => optional($vehicle->type)->name,
					'Chasis' => $vehicle->chassis,
					'Equipo' => $equipments,
					'Estado' => $vehicle->customer ? ($vehicle->state->name . ' - ' . $vehicle->customer->name) : optional($vehicle->state)->name
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

	<div class="text-gray-800">
		<br>
		@if(isset($vehicle->chassisModel->technicalHandbook))
			<a target="_blank" href="{{$vehicle->chassisModel->technicalHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> Manual técnico {{$vehicle->chassis}}</a><br>
		@endif
		@if(isset($vehicle->chassisModel->usageHandbook))
			<a target="_blank" href="{{$vehicle->chassisModel->usageHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> Manual de uso {{$vehicle->chassis}}</a><br>
		@endif

		@foreach($vehicle->equipments as $equipment)
			@if(isset($equipment->model->technicalHandbook))
				<a target="_blank" href="{{ $equipment->model->technicalHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> Manual técnico {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
			@endif
			@if(isset($equipment->model->usageHandbook))
				<a target="_blank" href="{{ $equipment->model->usageHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> Manual de uso {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
			@endif
		@endforeach
	</div>

	@if(isset($show_counters) && $show_counters)
		<div>
			<display-more>
				<template v-slot:head>
					@foreach($vehicle->counters->sortByDesc('completedPercent')->take(5) as $counter)
						<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
					@endforeach
				</template>
				<template v-slot:body>
					@foreach($vehicle->counters->sortByDesc('completedPercent')->slice(5) as $counter)
						<div class="mb-5">@include('fleet.vehicles.counters.progress')</div>
					@endforeach
				</template>
			</display-more>
		</div>
	@endif

	
@endcomponent