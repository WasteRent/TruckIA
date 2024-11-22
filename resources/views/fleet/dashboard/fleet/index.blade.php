@extends('layouts.fleet')

@section('title', __('Dashboard'))

@section('content')

	@include('fleet.dashboard.tabs', ['fleet' => true])

	<div class="py-4 font-bold text-xl flex items-center">
		<p class="mr-3">Seleccionar centro</p>
		<form action="">
			@php
				$customers = auth()->user()->allowedCustomers->count() ? auth()->user()->allowedCustomers : auth()->user()->fleet->customers;
			@endphp
			<select name="location_id" class="form-select" onchange="this.form.submit()">
				<option value="">Todos</option>
				@if($customers->count() == 1)
					<option value="{{ $customers->first()->id }}" selected>{{ $customers->first()->name }}</option>
				@else
					@foreach($customers->sortBy('name') as $customer)
					<option value="{{ $customer->id }}" @if(request()->query('location_id')==$customer->id) selected @endif>{{ $customer->name }}</option>
					@endforeach
				@endif
			</select>
		</form>
</div>

	<div class="sm:grid grid-cols-4 gap-4">
		@component('components.card')
			@include('fleet.dashboard.fleet.charts.maintenance_chassis')
		@endcomponent
		@component('components.card')
			@include('fleet.dashboard.fleet.charts.maintenance_equipment')
		@endcomponent
		@component('components.card')
			@include('fleet.dashboard.fleet.charts.itv')
		@endcomponent
		@component('components.card')
			@include('fleet.dashboard.fleet.charts.tacograph')
		@endcomponent
	</div>
	<div class="sm:grid grid-cols-12 gap-4">
		<div class="col-span-12">
			@component('components.card')
				@include('fleet.dashboard.fleet.charts.state')
			@endcomponent
		</div>
		@if(in_array(auth()->user()->fleet->id, [1, 6]))
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
		@endif
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
