@component('components.card')
	@slot('title', __('Datos del vehículo'))
	@if(Auth::user()->hasRole('garage'))
		@slot('corner')
			<a href="{{ route('garage.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-plus-circle mr-1"></i>{{ __('Crear O.R.') }}</a>
			<a href="{{ route('garage.vehicles.index') }}" class="btn-outline-gray mb-2 float-right"><i class="fas fa-search mr-1"></i>{{ __('Vista previa') }}</a>
		@endslot
	@endif

	@if(Auth::user()->hasRole('fleet') && in_array(auth()->user()->job, ['fleet_manager', 'mechanic']))
		@slot('corner')
            <a href="{{ route('fleet.vehicle.checklists.index', $vehicle) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-check-square mr-2"></i>{{ __('Checklist') }}</a>
            <a href="{{ route('fleet.fast-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-solid fa-wrench mr-1"></i>{{ __('Crear correctivo') }}</a>
			<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-outline-gray mb-2 mr-1"><i class="fas fa-plus-circle mr-1"></i>{{ __('Crear preventivo') }}</a>
			<a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn-outline-gray"><i class="fas fa-search mr-1"></i>{{ __('Ver ficha completa') }}</a>
		@endslot
	@endif


	@if(Auth::user()->hasRole('customer'))
        @slot('corner')
            <a class="btn-outline-gray" href="{{ route('customer.vehicle.checklists.index', $vehicle ) }}" target="_blank">
                <i class="fas fa-check-square mr-2"></i> {{ __('Checklist') }}
            </a>
        @endslot
    @endif

	<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
		<!-- Información principal -->
		<div class="lg:col-span-2 space-y-4">
			@include('fleet.vehicles.tracking')

			@php
				$equipments = "";
				foreach($vehicle->equipments as $equipment){
					$equipments .= "{$equipment->type} {$equipment->maker?->name} {$equipment->model?->name}<br>";
				}
			@endphp

			<div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-200">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<div class="space-y-3">
						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-id-card text-green-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Matrícula') }}</p>
								<p class="text-base font-bold text-gray-900 mt-1">
									@if($vehicle->internal_id)
										<span class="text-green-600">({{ $vehicle->internal_id }})</span>
									@endif
									{{ $vehicle->plate }}
								</p>
							</div>
						</div>

						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-car text-blue-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Tipo') }}</p>
								<p class="text-base font-semibold text-gray-900 mt-1">{{ optional($vehicle->type)->name }}</p>
							</div>
						</div>

						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-barcode text-purple-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Chasis') }}</p>
								<p class="text-base font-semibold text-gray-900 mt-1">{{ $vehicle->chassis }}</p>
							</div>
						</div>
					</div>

					<div class="space-y-3">
						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-cogs text-orange-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Equipo') }}</p>
								<div class="text-sm font-medium text-gray-900 mt-1">{!! $equipments !!}</div>
							</div>
						</div>

						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-circle text-green-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Estado') }}</p>
								<p class="text-sm font-semibold text-gray-900 mt-1">
									{{ $vehicle->customer ? ($vehicle->state?->name . ' - ' . $vehicle->customer->name) : optional($vehicle->state)->name }}
								</p>
							</div>
						</div>

						@if($vehicle->manufacturing_date)
						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-calendar text-indigo-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Fecha de fabricación') }}</p>
								<p class="text-sm font-semibold text-gray-900 mt-1">{{ Carbon\Carbon::parse($vehicle->manufacturing_date)->format('d/m/Y') }}</p>
							</div>
						</div>
						@endif

						@if($vehicle->location)
						<div class="flex items-start">
							<div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
								<i class="fas fa-map-marker-alt text-red-600 text-sm"></i>
							</div>
							<div class="flex-1">
								<p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Ubicación') }}</p>
								<p class="text-sm font-semibold text-gray-900 mt-1">{{ $vehicle->location->name }}</p>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>

		<!-- Imagen del vehículo -->
		<div class="lg:col-span-1">
			<div class="bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl p-6 border border-gray-200 h-full flex items-center justify-center">
				@if($vehicle->pictures->count() > 0)
				<a target="_blank" href="{{ $vehicle->getCover()->getLink() }}" class="block transform hover:scale-105 transition-transform duration-300">
					<img loading="lazy" class="rounded-xl shadow-xl w-full object-cover" style="max-height: 400px;" src="{{ $vehicle->getCover()->getLink() }}">
				</a>
				@else
					<div class="text-center">
						<i class="fas fa-image text-gray-300" style="font-size: 8rem;"></i>
						<p class="text-gray-400 mt-4 text-sm font-medium">{{ __('Sin imagen') }}</p>
					</div>
				@endif
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
		<!-- Notas -->
		<div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
			<div class="flex items-center mb-4">
				<div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
					<i class="fas fa-sticky-note text-yellow-600"></i>
				</div>
				<h4 class="text-lg font-bold text-gray-900">{{ __('Notas') }}</h4>
			</div>
			@if($vehicle->notes->count() > 0)
				<ul class="space-y-2">
					@foreach($vehicle->notes as $note)
					<li class="flex items-start p-3 bg-yellow-50 rounded-lg border border-yellow-200">
						<i class="fas fa-circle text-yellow-500 text-xs mt-1.5 mr-2"></i>
						<span class="text-sm text-gray-700">{!! $note->note !!}</span>
					</li>
					@endforeach
				</ul>
			@else
				<p class="text-sm text-gray-500 italic">{{ __('No hay notas registradas') }}</p>
			@endif
		</div>

		<!-- Manuales y Características -->
		<div class="space-y-6">
			<!-- Manuales técnicos -->
			@if(auth()->user()->allowOriginalPlans())
			<div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
				<div class="flex items-center mb-4">
					<div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
						<i class="fas fa-book text-blue-600"></i>
					</div>
					<h4 class="text-lg font-bold text-gray-900">{{ __('Manuales') }}</h4>
				</div>
				<div class="space-y-2">
					@if(isset($vehicle->chassisModel->technicalHandbook))
						<a target="_blank" href="{{$vehicle->chassisModel->technicalHandbook->getLink()}}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
							<i class="fas fa-file-pdf text-blue-600 mr-3"></i>
							<span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ __('Manual técnico') }} {{$vehicle->chassis}}</span>
						</a>
					@endif
					@if(isset($vehicle->chassisModel->usageHandbook))
						<a target="_blank" href="{{$vehicle->chassisModel->usageHandbook->getLink()}}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
							<i class="fas fa-file-pdf text-blue-600 mr-3"></i>
							<span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ __('Manual de uso') }} {{$vehicle->chassis}}</span>
						</a>
					@endif
					@foreach($vehicle->equipments as $equipment)
						@if(isset($equipment->model->technicalHandbook))
							<a target="_blank" href="{{ $equipment->model->technicalHandbook->getLink() }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
								<i class="fas fa-file-pdf text-blue-600 mr-3"></i>
								<span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ __('Manual técnico') }} {{ $equipment->maker->name }} {{ $equipment->model->name }}</span>
							</a>
						@endif
						@if(isset($equipment->model->usageHandbook))
							<a target="_blank" href="{{ $equipment->model->usageHandbook->getLink() }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
								<i class="fas fa-file-pdf text-blue-600 mr-3"></i>
								<span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ __('Manual de uso') }} {{ $equipment->maker->name }} {{ $equipment->model->name }}</span>
							</a>
						@endif
					@endforeach
				</div>
			</div>
			@endif

			<!-- Características técnicas -->
			<div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
				<div class="flex items-center mb-4">
					<div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
						<i class="fas fa-cog text-purple-600"></i>
					</div>
					<h4 class="text-lg font-bold text-gray-900">{{ __('Características técnicas') }}</h4>
				</div>
				<form action="{{ route('fleet.vehicles.characteristics.update', $vehicle) }}" method="post">
					@csrf
					@method('put')
					<textarea class="form-input w-full h-32 text-sm" rows="10" name="characteristics" placeholder="{{ __('Añadir características técnicas...') }}">{!! $vehicle->characteristics !!}</textarea>	
					<div class="flex justify-end mt-3">
						<button type="submit" class="btn-outline-blue">
							<i class="fas fa-save mr-2"></i>{{ __('Guardar cambios') }}
						</button>
					</div>
				</form>
			</div>
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