@extends('layouts.fleet')

@section('title', __('Dashboard'))

@section('content')

	@include('fleet.dashboard.tabs', ['fleet' => true])

		<div class="sm:grid grid-cols-12 gap-4">
			<div class="col-span-9 flex">
				@component('components.card')
					@include('fleet.dashboard.fleet.charts.state')
				@endcomponent
			</div>
			<div class="col-span-3">
				@component('components.card')
					@include('fleet.dashboard.fleet.charts.maintenance_chassis')
				@endcomponent
				@component('components.card')
					@include('fleet.dashboard.fleet.charts.maintenance_equipment')
				@endcomponent
			</div>
			<div class="col-span-4">
				@component('components.card')
					@slot('title', 'Vehículos Call off')
					<table>
					  <thead>
					    <tr>
					      <th>Matrícula</th>
					      <th>Cliente</th>
					      <th>Días parado</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($call_off_stats as $item)
					  	<tr>
					  		<td class="py-0">
					  			<a href="{{ route('fleet.vehicles.show', $item['vehicle']->id) }}">
					  				{{ $item['vehicle']->plate }}
					  			</a>
					  		</td>
					  		<td class="py-0">{{ Str::limit($item['customer']?->name, 20) }}</td>
					  		<td class="py-0 text-white font-bold @if($item['days_in_call_off'] > 3) bg-red-700 @else bg-yellow-700 @endif">{{ $item['days_in_call_off'] }}</td>
					  	</tr>
					  	@endforeach
					  </tbody>
					</table>
				@endcomponent
			</div>
			<div class="col-span-4">
				@component('components.card')
					@include('fleet.dashboard.fleet.charts.age')
				@endcomponent
			</div>
			<div class="col-span-4">
				@component('components.card')
					@include('fleet.dashboard.fleet.charts.mechanic')
				@endcomponent
			</div>
			<div class="col-span-6">
				@include('fleet.dashboard.fleet.recent_orders')
			</div>
			<div class="col-span-6 flex">
				@include('fleet.dashboard.fleet.recent_alerts')
			</div>
			<div class="col-span-6 flex">
				@include('fleet.dashboard.fleet.recent_incidents')
			</div>
			<div class="col-span-6 flex">
				@include('fleet.dashboard.fleet.recent_activity')
			</div>
		</div>
	
@endsection
