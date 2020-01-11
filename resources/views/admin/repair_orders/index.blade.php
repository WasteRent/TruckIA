@extends('layouts.admin')

@section('title', 'Ordenes de Reparación')

@section('content')

	@component('components.search-card')
		@include('admin.repair_orders.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		<div class="float-right my-2 mr-3">
			<a href="{{ route('admin.repair-orders.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		</div>
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
		  	  <td class="px-6 py-2">{{ $order->garage ? $order->garage->name:'' }}</td>
		  	  <td class="px-6 py-2">{{ $order->vehicle ? $order->vehicle->plate:'' }}</td>
		  	  <td class="px-6 py-2">{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td class="px-6 py-2">
		  	  	<span class="{{ $order->completed ? 'bg-green-200 text-green-800':'bg-red-200 text-red-800' }} rounded-full px-3 py-1 text-xs">
		  	  		{{ $order->completed ? 'Completada':'Pendiente' }}
		  	  	</span>
		  	  </td>
		  	  <td class="px-6 py-2">
		  	  	@if($order->garage && $order->vehicle)
		  	  	<a class="mr-2" href="{{ route('admin.repair-orders.show', $order) }}">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  	<a href="{{ route('admin.repair-orders.vehicles.edit', [$order, $order->vehicle]) }}" class="mr-2">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
</div>
@endsection
