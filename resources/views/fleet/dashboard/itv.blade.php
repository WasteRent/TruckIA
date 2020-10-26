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

	<div>
		<h3 class="text-lg leading-6 font-medium text-gray-900">
			En curso
		</h3>
	</div>
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
		@foreach($ongoing as $vehicle) 	
			@include('fleet.dashboard.itv_card')
		@endforeach
	</div>

	<div class="mt-8"> 
		<h3 class="text-lg leading-6 font-medium text-gray-900">
			Próximas
		</h3>
	</div>
	
		@foreach($comming->groupBy(function($i) {
			return Carbon\Carbon::parse($i->itv_date)->format('m');
		}) as $month => $vehicles)

			<div class="mt-4 text-indigo-800 font-medium">
				{{ Carbon\Carbon::create()->day(1)->month($month)->format('M') }}
			</div>

			<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
				@foreach($vehicles as $vehicle)
					@if(!$ongoing->contains($vehicle))
						@include('fleet.dashboard.itv_card')
					@endif
				@endforeach
			</div>
		@endforeach

	<div class="mt-8">
		<h3 class="text-lg leading-6 font-medium text-gray-900">
			Caducadas
		</h3>
	</div>
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
		@foreach($expired as $vehicle) 	
			@if(!$ongoing->contains($vehicle))
				@include('fleet.dashboard.itv_card')
			@endif
		@endforeach
	</div>

@endsection
