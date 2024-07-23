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
		      <th class="hidden sm:table-cell">ID</th>
		      <th>Vehículo</th>
		      <th class="hidden sm:table-cell">Solicitado</th>
		      <th>Estado</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr >
		  	  <td class="hidden sm:table-cell">
		  	  	<p>{{ $order->id }}</p>
		  	  	@if(count($order->assigned_user_id ?? []))
		  	  		<small class="text-indigo-700">Asignada a: {{ $order->getAssignedUsers()?->pluck('name')->join(', ') }}</small>
		  	  	@endif
		  	  </td>
		  	  <td>@if($order->vehicle->internal_id) ({{ $order->vehicle->internal_id }}) @endif {{ $order->vehicle->plate }} {{ $order->vehicle->chassis }}</td>
		  	  <td class="hidden sm:table-cell">{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
		  	  	<span class="{{ $order->state?->color }} rounded-full px-3 py-1 text-xs">
		  	  		{{ $order->state->name }}
		  	  	</span>
		  	  </td>
		  	  <td>
		  	  	@if(!$order->operations->count())
					<a href="{{ route('garage.repair-orders.operations.index', $order) }}">
				@else
					<a href="{{ route('garage.repair-orders.show', $order) }}">
				@endif
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
