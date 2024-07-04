@component('components.card')
	@slot('title', __('Datos del vehículo'))
	@if(Auth::user()->hasRole('garage'))
	@slot('corner')
		<a href="{{ route('garage.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-plus-circle mr-1"></i>{{ __('Crear O.R.') }}</a>
		<a href="{{ route('garage.vehicles.index') }}" class="btn-outline-gray mb-2 float-right"><i class="fas fa-search mr-1"></i>{{ __('Vista previa') }}</a>
	@endslot
	@endif
	
	@if(Auth::user()->hasRole('fleet'))
		@slot('corner')
			<a href="{{ route('fleet.fast-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-solid fa-wrench mr-1"></i>{{ __('Crear correctivo') }}</a>
			<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-plus-circle mr-1"></i>{{ __('Crear preventivo') }}</a>
			<a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn-outline-gray"><i class="fas fa-search mr-1"></i>{{ __('Ver ficha completa') }}</a>
		@endslot
	@endif

	<div class="sm:flex">
		<div class="sm:w-2/3">
			@include('fleet.vehicles.tracking')
			
			@php 
				$equipments = "";
				foreach($vehicle->equipments as $equipment){
					$equipments .= "{$equipment->type} {$equipment->maker?->name} {$equipment->model?->name}<br>";
				}
			@endphp

			@component('components.table')
				@slot('items', [
					__('Matrícula') => $vehicle->internal_id
									? "({$vehicle->internal_id}) {$vehicle->plate}"
									: $vehicle->plate,
					__('Tipo') => optional($vehicle->type)->name,
					__('Chasis') => $vehicle->chassis,
					__('Equipo') => $equipments,
					__('Estado') => $vehicle->customer ? ($vehicle->state?->name . ' - ' . $vehicle->customer->name) : optional($vehicle->state)->name,
					__('Fecha de fabricación') => $vehicle->manufacturing_date ? Carbon\Carbon::parse($vehicle->manufacturing_date)->format('d/m/Y'):null,
					__('Ubicación') => $vehicle->location?->name,
				])
			@endcomponent


			
		</div>
		<div class="sm:w-1/3 ml-4 mt-4 sm:mt-0 flex justify-center">
			@if($vehicle->pictures->count() > 0)
			<a target="_blank" href="{{ $vehicle->getCover()->getLink() }}">
				<img loading="lazy" class="rounded-lg inline-block w-full max-h-72" src="{{ $vehicle->getCover()->getLink() }}">
			</a>
			@else
				<i class="fas fa-image text-gray-300" style="font-size: 12rem;"></i>
			@endif
		</div>
	</div>

	<div class="md:grid grid-cols-2 gap-5 mt-5">
		<div class="">
			<strong class="underline">Notas</strong>
			<ul class="text-xs list-disc ml-4">
				@foreach($vehicle->notes as $note)
				<li>{!! $note->note !!}</li>
				@endforeach
			</ul>
		</div>
		<div>
			@if(auth()->user()->allowOriginalPlans())
			<div class="text-gray-800">
				<br>
				@if(isset($vehicle->chassisModel->technicalHandbook))
					<a target="_blank" href="{{$vehicle->chassisModel->technicalHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> {{ __('Manual técnico') }} {{$vehicle->chassis}}</a><br>
				@endif
				@if(isset($vehicle->chassisModel->usageHandbook))
					<a target="_blank" href="{{$vehicle->chassisModel->usageHandbook->getLink()}}"><i class="fas fa-cloud-download-alt"></i> {{ __('Manual de uso') }} {{$vehicle->chassis}}</a><br>
				@endif

				@foreach($vehicle->equipments as $equipment)
					@if(isset($equipment->model->technicalHandbook))
						<a target="_blank" href="{{ $equipment->model->technicalHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> {{ __('Manual técnico') }} {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
					@endif
					@if(isset($equipment->model->usageHandbook))
						<a target="_blank" href="{{ $equipment->model->usageHandbook->getLink() }}"><i class="fas fa-cloud-download-alt"></i> {{ __('Manual de uso') }} {{ $equipment->maker->name }} {{ $equipment->model->name }}</a><br>
					@endif
				@endforeach
			</div>
			@endif
		</div>
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