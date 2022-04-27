@component('components.card', ['is_table' => true])
	@slot('title')
		<div class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
			  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
			</svg>
			<span>{{ __('Últimas ordenes') }}</span>
		</div>
	@endslot
	@slot('corner')
		<a class="text-xs flex items-center text-blue-700" href="{{ route('fleet.repair-orders.index') }}">
			<span class="mr-2">Ver más</span>
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
			</svg>
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
	  	<tr>
	  	  <td class="hidden sm:table-cell flex items-center">
	  	  	<span>{{ $order->id }}</span>
	  	  	@if($order->assigned)
	  	  		<small class="text-blue-700">{{ __('Asignada a') }}: {{ $order->assigned->name }}</small>
	  	  	@endif
	  	  </td>
	  	  <td>
	  	  	{{ optional($order->vehicle)->plate }} {{ optional($order->vehicle)->chassis }}
	  	  </td>
	  	  <td>
  	  		<span class="badge {{ $order->state->color }}">
  	  		  {{ __($order->state->name) }}
  	  		</span>
	  	  </td>
	  	  <td>
			<a href="{{ route('fleet.repair-orders.show', $order) }}">
				<i class="icon fas fa-eye"></i>
			</a>
	  	  </td>
	  	</tr>
	  	@endforeach
	  </tbody>
	</table>
@endcomponent