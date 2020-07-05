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
	@foreach($vehicles as $vehicle) 	
		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-4 pt-5">
			<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
				<div class="flex justify-between">
					<div class="text-2xl font-semibold text-gray-900">
						{{ $vehicle->plate }}
						<div class="text-xs text-gray-600">
							<p>{{ $vehicle->chassis }}</p>
							<p>{{ $vehicle->equipment }}</p>
						</div>
					</div>

					<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($vehicle->getCover())->getLink() }}">
				</div>		
			</a>

			@if($vehicle->itv_date < date('Y-m-d'))
				<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-red-100 text-red-800" title="{{ $vehicle->itv_date }}">
				  Caducada {{ Carbon\Carbon::parse($vehicle->itv_date)->diffForHumans() }}
				</span>
			@else
				<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-yellow-100 text-yellow-800" title="{{ $vehicle->itv_date }}">
				  Caduca {{ Carbon\Carbon::parse($vehicle->itv_date)->diffForHumans() }}
				</span>
			@endif

			<div class="text-right text-xs text-indigo-800 py-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $vehicle) }}"><i class="far fa-eye"></i>&nbsp;Ficha</a>
				<a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id, 'type' => 'pre-itv']) }}"><i class="fas fa-plus-circle"></i> O.R.</a>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
