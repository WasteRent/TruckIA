@extends('layouts.fleet')

@section('title', 'Dashboard - Preventivos')

@section('content')

	@component('components.search-card')
		@include('fleet.dashboard.search', ['route' => 'fleet.dashboard.preventives'])
	@endcomponent
	
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($vehicle_counters as $vehicle_counter) 	
		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-4 pt-5">
			<a href="{{ route('fleet.vehicles.show', $vehicle_counter->first()->vehicle) }}">
				<div class="flex justify-between">
					<div class="text-2xl font-semibold text-gray-900">
						{{ $vehicle_counter->first()->vehicle->plate }}
						<div class="text-xs text-gray-800">
							<span class="px-2 bg-indigo-100 rounded-full">
								@if ($vehicle_counter->first()->vehicle->assigned_customer_id)
									<a href="{{ route('fleet.customers.edit', $vehicle_counter->first()->vehicle->assigned_customer_id )  }}">
										{{ optional($vehicle_counter->first()->vehicle->customer)->name }}
									</a>
								@endif
								</span>
							<p class="mt-2">{{ $vehicle_counter->first()->vehicle->chassis }}</p>
							<p>{{ $vehicle_counter->first()->vehicle->equipment }}</p>
						</div>
					</div>

					<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($vehicle_counter->first()->vehicle->getCover())->getLink() }}">
				</div>
				
				
				<fieldset>
					<legend>Chasis</legend>
					<div class="pb-3">
						@foreach($vehicle_counter->where('vehicle_category', 'chassis')->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Equipos</legend>
					<div class="pb-3">
						@foreach($vehicle_counter->where('vehicle_category', 'equipment')->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
			</a>

			<div class="text-right text-xs text-indigo-800 py-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $vehicle_counter->first()->vehicle) }}"><i class="far fa-eye"></i>&nbsp;Ficha</a>
				<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle_counter->first()->vehicle->id]) }}"><i class="fas fa-plus-circle"></i> O.R.</a>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
