@extends('layouts.fleet')

@section('title', __('Ordenes de Reparación'))

@section('content')

	@component('components.search-card')
		@include('fleet.repair_orders.search')
	@endcomponent

	@component('components.tabs', [
		'items' => [
			[
				'name' => __('Todos').' ('.App\Models\RepairOrder::filter(request()->except('type'))->count().')',
				'url' => route('fleet.repair-orders.index', request()->except('type')),
				'active' => !in_array(request()->query('type'), ['preventive', 'corrective', 'pre-itv'])
			],
			[
				'name' => __('Preventivos').' ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'preventive')->count().')',
				'url' => route('fleet.repair-orders.index', array_merge(request()->all(), ['type' => 'preventive'])),
				'active' => request()->query('type') == 'preventive'
			],
			[
				'name' => __('Correctivos').' ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'corrective')->count().')',
				'url' => route('fleet.repair-orders.index', array_merge(request()->all(), ['type' => 'corrective'])),
				'active' => request()->query('type') == 'corrective'
			],
			[
				'name' => __('Pre-ITV').' ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'pre-itv')->count().')',
				'url' => route('fleet.repair-orders.index', array_merge(request()->all(), ['type' => 'pre-itv'])),
				'active' => request()->query('type') == 'pre-itv'
			],
			[
				'name' => __('Semanal').' ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'weekly')->count().')',
				'url' => route('fleet.repair-orders.index', array_merge(request()->all(), ['type' => 'weekly'])),
				'active' => request()->query('type') == 'weekly'
			]
		]
	])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.repair-orders.create', request()->query()) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th class="hidden sm:table-cell">ID</th>
		      <th>{{ __('Taller') }}</th>
		      <th>{{ __('Vehículo') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Solicitado') }}</th>
		      @if(Auth::user()->fleet->module_OR)<th>{{ __('Estado') }}</th>@endif
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr>
		  	  <td class="hidden sm:table-cell">
		  	  	<p>{{ $order->id }}</p>
		  	  	@if($order->assigned)
		  	  		<small class="text-indigo-700">{{ __('Asignada a') }}: {{ $order->assigned->name }}</small>
		  	  	@endif
		  	  </td>
		  	  <td class="font-medium">
	  	  		{{ optional($order->garage)->name }}
	  	  		<stars :rating="{{ optional($order->garage)->getStarsAverage() ?? 0 }}"></stars>
		  	  </td>
		  	  <td class="font-medium">
		  	  	{{ optional($order->vehicle)->plate }}
		  	  </td>
		  	  <td class="hidden sm:table-cell">{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
				@if(Auth::user()->fleet->module_OR)
		  	  <td>
	  	  		<span class="badge {{ $order->state->color }}">
	  	  		  {{ __($order->state->name) }}
	  	  		</span>
		  	  </td>
				@endif
		  	  <td>
		  	  	<div class="flex">
					@if(!$order->operations->count())
					 	@if(Auth::user()->fleet->module_OR)
							<a href="{{ route('fleet.repair-orders.operations.index', $order) }}"  class="mr-3">
						@else
							<a href="{{ route('fleet.repair-orders.store-simplified', $order) }}"  class="mr-3">
						@endif 
					@else
						@if(Auth::user()->fleet->module_OR)
							<a href="{{ route('fleet.repair-orders.show', $order) }}"  class="mr-3">
						@else  
							<a href="{{ route('fleet.repair-orders.store-simplified', $order) }}"  class="mr-3">
						@endif
					@endif
					<i class="icon fas fa-eye fa-lg"></i>
					</a>	
		  	  		@if(!$order->isFinished())
			  	  		<form onsubmit="return confirmDelete()" method="POST" action="{{ route('fleet.repair-orders.destroy', $order) }}">
			  	  			@csrf
			  	  			@method('DELETE')
			  	  			<button><i class="icon fas fa-trash-alt fa-lg"></i></button>
			  	  		</form>
		  	  		@endif
	  	  		</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
</div>

	{{ $repair_orders->appends(request()->query())->links() }}

@endsection
