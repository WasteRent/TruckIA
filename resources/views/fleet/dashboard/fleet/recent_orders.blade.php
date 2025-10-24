@component('components.card', ['is_table' => true])
	@slot('title')
		<div class="flex items-center">
			<div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
				<i class="fas fa-wrench text-blue-600"></i>
			</div>
			<span class="font-bold">{{ __('Últimas Órdenes') }}</span>
		</div>
	@endslot
	@slot('corner')
		<a class="flex items-center px-4 py-2 text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 rounded-lg transition-colors" href="{{ route('fleet.repair-orders.index') }}">
			<span class="mr-2">Ver todas</span>
			<i class="fas fa-arrow-right"></i>
		</a>
	@endslot
	<table>
	  <thead>
	    <tr>
	      <th class="hidden sm:table-cell">ID</th>
	      <th>{{ __('Vehículo') }}</th>
	      <th>{{ __('Estado') }}</th>
	      <th></th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($latest_orders as $order)
	  	<tr class="hover:bg-gray-50">
	  	  <td class="hidden sm:table-cell">
	  	  	<div class="flex flex-col">
	  	  		<span class="font-bold text-gray-900">#{{ $order->id }}</span>
	  	  		@if(count($order->assigned_user_id ?? []))
	  	  			<small class="text-xs text-green-600 font-semibold mt-1">
	  	  				<i class="fas fa-user text-xs mr-1"></i>{{ $order->getAssignedUsers()?->pluck('name')->join(', ') }}
	  	  			</small>
	  	  		@endif
	  	  	</div>
	  	  </td>
	  	  <td>
	  	  	@if($order->vehicle)
	  	  	<a href="{{ route('fleet.vehicles.show', $order->vehicle) }}" class="text-green-600 hover:text-green-700 font-semibold hover:underline">
	  	  		<i class="fas fa-car mr-1"></i>{{ optional($order->vehicle)->plate }} {{ optional($order->vehicle)->chassis }}
	  	  	</a>
	  	  	@endif
	  	  </td>
	  	  <td>
  	  		<span class="badge {{ $order->state?->color }} font-semibold">
  	  		  {{ __($order->state?->name) }}
  	  		</span>
	  	  </td>
	  	  <td>
			<a href="{{ route('fleet.repair-orders.show', $order) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 hover:bg-green-200 text-green-700 transition-colors">
				<i class="fas fa-eye"></i>
			</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
@endcomponent