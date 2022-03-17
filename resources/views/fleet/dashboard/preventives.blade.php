@extends('layouts.fleet')

@section('title', __('Dashboard - Preventivos'))

@section('content')

	@component('components.search-card')
		@include('fleet.dashboard.search', ['route' => 'fleet.dashboard.preventives'])
	@endcomponent
	
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($vehicles as $vehicle) 	
		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-4 pt-5">
			<div class="flex justify-between">
				<div class="text-2xl font-semibold text-gray-900">
					<a href="{{ route('fleet.vehicles.show', $vehicle) }}">{{ $vehicle->plate }}</a>
					<div class="text-xs text-gray-800">
						<span class="px-2 bg-indigo-100 rounded-full">
							@if ($vehicle->assigned_customer_id)
								<a href="{{ route('fleet.customers.edit', $vehicle->assigned_customer_id )  }}">
									{{ optional($vehicle->customer)->name }}
								</a>
							@endif
							</span>
						<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
							<p class="mt-2">{{ $vehicle->chassis }}</p>
							<p>{{ $vehicle->equipment }}</p>
						</a>
					</div>
				</div>
				<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
					<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($vehicle->getCover())->getLink() }}">
				</a>
			</div>
				
			<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
				<fieldset>
					<legend>{{ __('Chasis') }}</legend>
					<div class="pb-3">
						@foreach($vehicle->counters()
								->where('vehicle_category', 'chassis')
								->get()
								->filter
								->isThresholdReached()
								->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
				
				<fieldset>
					<legend>{{ __('Equipos') }}</legend>
					<div class="pb-3">
						@foreach($vehicle->counters()
								->where('vehicle_category', 'equipment')
								->get()
								->filter
								->isThresholdReached()
								->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
			</a>

			<div class="text-right text-xs text-indigo-800 pt-4 pb-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $vehicle) }}"><i class="far fa-eye"></i>&nbsp;{{ __('Ficha') }}</a>
				<span class="p-1 border border-indigo-700 text-indigo-700 rounded-sm rounded-lg"><a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}"><i class="p-1 fas fa-plus"></i>{{ __('Crear O.R.') }}</a></span>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
