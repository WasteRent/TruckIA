@extends('layouts.fleet')

@section('title', __('Mecánicos'))

@section('content')

	@component('components.search-card')
		@include('fleet.mechanics.search', ['route' => 'fleet.mechanics.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.mechanics',request()->query()) }}"><i class="fas fa-lg fa-file-excel"></i></a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>{{ __('Orden de Reparación') }}</th>
		      <th>{{ __('Mecanico') }}</th>
		      <th>{{ __('Tiempo invertido') }}</th>
		      <th>{{ __('Vehículo') }}</th>
		      <th>{{ __('Taller') }}</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($repair_orders as $order)
		  	<tr>
		  	  <td>
                {{$order->id}}
		  	  </td>		  	
		  	  <td>
                {{$order->getAssignedUsers()?->pluck('name')->join(', ')}}
		  	  </td>		  	
		  	  <td>
				@foreach($order->operations->flatMap->repairOrderOperationHistories->groupBy('user_id') as $userId => $histories)
					<p class="text-gray-800">
						<strong>{{ \App\User::find($userId)?->name ?? 'Mecánico desconocido' }}</strong>: 
						{{ number_format($histories->sum('hours_spent'), 2, ',', '.') }} h
					</p>
				@endforeach
			</td>					  
		  	  <td>
                @if($order?->vehicle?->internal_id)({{ $order?->vehicle?->internal_id }})@endif {{ optional($order->vehicle)->plate }}
            </td>		  	
            <td>
                {{$order->garage->name}}
		  	  </td>		  	
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $repair_orders->appends(request()->query())->links() }}
@endsection
