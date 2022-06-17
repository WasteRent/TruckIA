@extends('layouts.fleet')

@section('title', __('Dashboard'))

@section('content')

	@include('fleet.dashboard.tabs', ['fleet' => true])

	<div class="sm:grid grid-cols-3 gap-4">
		<div class="col-span-2">
			@component('components.card')
				@include('fleet.dashboard.fleet.charts.state')
			@endcomponent

			
		</div>
		<div class="col-span-1">
			@component('components.card')
				@include('fleet.dashboard.fleet.charts.maintenance')
			@endcomponent

			@component('components.card')
				@include('fleet.dashboard.fleet.charts.mechanic')
			@endcomponent

			@component('components.card')
				@include('fleet.dashboard.fleet.charts.age')
			@endcomponent
		</div>
		<div class="col-span-3">
			@include('fleet.dashboard.fleet.recent_orders')
		</div>
		<div class="col-span-1 flex">
			@include('fleet.dashboard.fleet.recent_alerts')
		</div>
		<div class="col-span-1 flex">
			@include('fleet.dashboard.fleet.recent_incidents')
		</div>
		<div class="col-span-1 flex">
			@include('fleet.dashboard.fleet.recent_activity')
		</div>
	</div>
	
@endsection
