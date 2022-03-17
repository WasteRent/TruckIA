@extends('layouts.fleet')

@section('title', $customer->name)

@section('content')

	@include('fleet.customers.tabs', ['active_vehicles' => true])
	

	<br><br>

	@component('components.card', ['is_table' => true])
		@slot('title', __('Vehículos actuales'))
		<table>
			<thead>
				<tr>
					<th>{{ __('Matrícula') }}</th>
					<th>{{ __('Chasis') }}</th>
					<th>{{ __('Equipo') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($customer->vehicles as $vehicle)
				<tr>
					<td><a class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline" href="{{ route('fleet.vehicles.show', $vehicle) }}">{{$vehicle->plate}}</a></td>
					<td>{{$vehicle->chassis}}</td>
					<td>{{$vehicle->equipment}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', __('Vehículos anteriores'))
		<table>
			<thead>
				<tr>
					<th>{{ __('Matrícula') }}</th>
					<th>{{ __('Chasis') }}</th>
					<th>{{ __('Equipo') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($customer->vehiclesHistory as $history)
					@if($history->vehicle && !$customer->vehicles->contains($history->vehicle)) 
					<tr>
						<td><a class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline" href="{{ route('fleet.vehicles.show', $history->vehicle) }}">{{$history->vehicle->plate}}</a></td>
						<td>{{$history->vehicle->chassis}}</td>
						<td>{{$history->vehicle->equipment}}</td>
					</tr>
					@endif
				@endforeach
			</tbody>
		</table>
	@endcomponent
@endsection