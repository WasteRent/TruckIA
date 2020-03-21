@extends('layouts.admin')

@section('title', 'Ordenes de Reparación')

@section('content')

	@component('components.search-card')
		@include('admin.repair_orders.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.repair-orders.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table class="table-auto w-full">
		  <thead class="uppercase text-xs font-bold tracking-wide">
		    <tr class="bg-gray-100 border-t border-b">
		      <td class="px-6 py-2">ID</td>
		      <td class="px-6 py-2">Taller</td>
		      <td class="px-6 py-2">Vehículo</td>
		      <td class="px-6 py-2">Solicitado</td>
		      <td class="px-6 py-2">Estado</td>
		      <td class="px-6 py-2"></td>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{ $order->id }}</td>
		  	  <td class="px-6 py-2">
		  	  	@if($order->garage)
		  	  		{{ $order->garage->name }}
		  	  		<stars :rating="{{ $order->garage->getStarsAverage() ?? 0 }}"></stars>
		  	  	@endif
		  	  </td>
		  	  <td class="px-6 py-2">
		  	  	@if($order->vehicle)
		  	  		{{ $order->vehicle->plate }}
		  	  	@endif
		  	  </td>
		  	  <td class="px-6 py-2">{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td class="px-6 py-2">
	  	  		<span class="{{ $order->state->color }} rounded-full px-3 py-1 text-xs font-medium">
	  	  			{{ $order->state->name }}
	  	  		</span>
		  	  </td>
		  	  <td class="px-6 py-2">
		  	  
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
</div>
@endsection
