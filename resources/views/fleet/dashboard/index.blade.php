@extends('layouts.fleet')

@section('title', __('Dashboard'))

@section('content')

	@include('fleet.dashboard.tabs')

	<div class="flex flex-wrap">
		<div class="w-2/3 pr-4">
			@component('components.card')
				@include('fleet.dashboard.charts.state')
			@endcomponent
		</div>
		<div class="w-1/3">
			@component('components.card')
				@include('fleet.dashboard.charts.maintenance')
			@endcomponent
		</div>
		<div class="w-1/3 pr-4">
			@include('fleet.dashboard.recent_alerts')
		</div>
		<div class="w-1/3 pr-4">
			@include('fleet.dashboard.recent_incidents')
		</div>
		<div class="w-1/3 pr-4">
			@include('fleet.dashboard.recent_activity')
		</div>
		<div class="w-full">
			@include('fleet.dashboard.recent_orders')
		</div>
	</div>
	
	@include('fleet.dashboard.status')
@endsection
