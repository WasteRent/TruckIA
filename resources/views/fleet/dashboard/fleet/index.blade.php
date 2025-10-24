@extends('layouts.fleet')

@section('title', __('Dashboard'))

@section('content')

	@include('fleet.dashboard.tabs', ['fleet' => true])

	<div class="mb-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
		<div class="flex items-center justify-between">
			<div class="flex items-center">
				<div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
					<i class="fas fa-filter text-white text-xl"></i>
				</div>
				<div>
					<p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">{{ __('Filtrar por') }}</p>
					<p class="text-lg font-bold text-gray-900">{{ __('Centro de trabajo') }}</p>
				</div>
			</div>
			<form action="" class="flex items-center">
				@php
					$customers = auth()->user()->allowedCustomers->count() ? auth()->user()->allowedCustomers : auth()->user()->fleet->customers;
				@endphp
				<select name="location_id" class="form-select min-w-[250px] shadow-md" onchange="this.form.submit()">
					<option value="">{{ __('Todos los centros') }}</option>
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
	</div>

	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
	<!-- Gráfico de estado full width -->
	<div class="mb-6">
		@component('components.card')
			@include('fleet.dashboard.fleet.charts.state')
		@endcomponent
	</div>

	<!-- Grid de gráficos y estadísticas -->
	<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
		@if(in_array(auth()->user()->fleet->id, [1, 6]))
		<div class="lg:col-span-4">
			@component('components.card', ['is_table' => true])
				@slot('title')
					<div class="flex items-center">
						<div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-2">
							<i class="fas fa-pause-circle text-orange-600"></i>
						</div>
						<span>Vehículos Call off</span>
					</div>
				@endslot
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
						<td>
							<a href="{{ route('fleet.vehicles.show', $item['vehicle']->id) }}" class="text-green-600 hover:text-green-700 font-semibold">
								{{ $item['vehicle']->plate }}
							</a>
						</td>
						<td>{{ Str::limit($item['customer']?->name, 20) }}</td>
						<td>
							<span class="px-3 py-1 rounded-full text-xs font-bold text-white @if($item['days_in_call_off'] > 3) bg-red-600 @else bg-yellow-600 @endif">
								{{ $item['days_in_call_off'] }} días
							</span>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			@endcomponent
		</div>
		@endif
		
		@if(in_array(auth()->user()->job, ['fleet_manager']))
		<div class="lg:col-span-4">
			@component('components.card')
				@include('fleet.dashboard.fleet.charts.age')
			@endcomponent
		</div>
		<div class="lg:col-span-4">
			@component('components.card')
				@include('fleet.dashboard.fleet.charts.mechanic')
			@endcomponent
		</div>
		@endif
	</div>

	<!-- Grid de actividad reciente -->
	@if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss']))
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<div>
			@include('fleet.dashboard.fleet.recent_orders')
		</div>
		<div>
			@include('fleet.dashboard.fleet.recent_alerts')
		</div>
		<div>
			@include('fleet.dashboard.fleet.recent_incidents')
		</div>
		<div>
			@include('fleet.dashboard.fleet.recent_activity')
		</div>
	</div>
	@endif

@endsection
