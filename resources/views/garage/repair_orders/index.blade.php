@extends('layouts.garage')

@section('title', 'Ordenes de Reparación')

@section('content')
	@component('components.search-card')
		@include('garage.repair_orders.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('garage.repair-orders.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>

		<table >
		  <thead >
		    <tr >
		      <th>ID</th>
		      <th>Vehículo</th>
		      <th>Solicitado</th>
		      <th>Estado</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr >
		  	  <td>{{ $order->id }}</td>
		  	  <td>{{ $order->vehicle ? $order->vehicle->plate:'' }}</td>
		  	  <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
		  	  	<span class="{{ $order->state->color }} rounded-full px-3 py-1 text-xs">
		  	  		{{ $order->state->name }}
		  	  	</span>
		  	  </td>
		  	  <td>
		  	  	@if(!$order->appointment && !$order->isFinished())
		  	  		<a href="{{ route('garage.appointments.create', ['vehicle_id' => $order->vehicle->id, 'repair_order_id' => $order->id]) }}" class="mr-2">
		  	  			<i class="icon fas fa-calendar-alt"></i>
		  	  		</a>
		  	  	@endif
		  	  	<a class="mr-2" href="{{ route('garage.repair-orders.show', $order) }}">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
