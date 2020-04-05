@extends('layouts.fleet')

@section('title', 'Ordenes de Reparación')

@section('content')

	@component('components.search-card')
		@include('fleet.repair_orders.search')
	@endcomponent

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Todos',
				'url' => route('fleet.repair-orders.index'),
				'active' => !in_array(request()->query('type'), ['preventive', 'corrective', 'pre-itv'])
			],
			[
				'name' => 'Preventivos',
				'url' => route('fleet.repair-orders.index', ['type' => 'preventive']),
				'active' => request()->query('type') == 'preventive'
			],
			[
				'name' => 'Correctivos',
				'url' => route('fleet.repair-orders.index', ['type' => 'corrective']),
				'active' => request()->query('type') == 'corrective'
			],
			[
				'name' => 'Pre-ITV',
				'url' => route('fleet.repair-orders.index', ['type' => 'pre-itv']),
				'active' => request()->query('type') == 'pre-itv'
			]
		]
	])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.repair-orders.create', request()->query()) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>ID</th>
		      <th>Taller</th>
		      <th>Vehículo</th>
		      <th>Solicitado</th>
		      <th>Estado</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr>
		  	  <td>{{ $order->id }}</td>
		  	  <td class="font-medium">
	  	  		{{ $order->garage->name }}
	  	  		<stars :rating="{{ $order->garage->getStarsAverage() ?? 0 }}"></stars>
		  	  </td>
		  	  <td class="font-medium">
		  	  	{{ $order->vehicle->plate }}
		  	  </td>
		  	  <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
	  	  		<span class="badge {{ $order->state->color }}">
	  	  		  {{ $order->state->name }}
	  	  		</span>
		  	  </td>
		  	  <td>
		  	  	<a href="{{ route('fleet.repair-orders.show', $order) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
</div>
@endsection
