@extends('layouts.fleet')

@section('title', 'Dashboard')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Preventivos',
				'url' => route('fleet.dashboard.preventives'),
				'active' => request()->is('*preventives*')
			],
			[
				'name' => 'ITV',
				'url' => route('fleet.dashboard.itv'),
				'active' => request()->is('*itv*')
			]
		]
	])
	@endcomponent
	
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($counters as $counter) 	
		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-4 pt-5">
			<a href="{{ route('fleet.vehicles.show', $counter->vehicle) }}">
				<div class="flex justify-between">
					<div class="text-2xl leading-8 font-semibold text-gray-900">
						{{ $counter->vehicle->plate }}
						<div class="text-xs text-gray-600">
							{{ $counter->vehicle->chassis }}
						</div>
					</div>

					<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($counter->vehicle->getCover())->getLink() }}">
				</div>
				
				@include('fleet.vehicles.counters.progress')
			</a>

			<div class="text-right text-xs text-indigo-800 py-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $counter->vehicle) }}"><i class="far fa-eye"></i>&nbsp;Ficha</a>
				<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $counter->vehicle->id]) }}"><i class="fas fa-plus-circle"></i> O.R.</a>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
