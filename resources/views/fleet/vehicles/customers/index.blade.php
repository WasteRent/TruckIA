@extends('layouts.fleet')

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_customers' => true])

	@component('components.search-card')
		@include('fleet.customers.search', ['route' => ['fleet.vehicles.customers.index', $vehicle]])
	@endcomponent

	@if(count($customers_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar cliente')

			<table >
			  <thead >
			    <tr >
			      <th>Nombre</th>
			      <th>Email</th>
			      <th>Tel.</th>
			      <th>Dirección</th>
			      <th></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($customers_search as $customer)
			  	<tr >
			  	  <td>{{$customer->name}}</td>
			  	  <td>{{$customer->email}}</td>
			  	  <td>{{$customer->phone}}</td>
			  	  <td>{{$customer->full_address}}</td>
			  	  <td>
		  	  		<form method="POST" action="{{ route('fleet.vehicles.customers.store', $vehicle) }}">
		  	  			@csrf
		  	  			<input type="hidden" name="customer_id" value="{{$customer->id}}">
		  	  			<button><i class="icon fas fa-plus-circle"></i></button>
		  	  		</form>
			  	  </td>
			  	</tr>
			  	@endforeach
			  </tbody>
			</table>
		@endcomponent
	@endif

	<br><br>
	
	@if($vehicle->customer)
		@component('components.card')
			@slot('title', 'Cliente actual')
			@slot('corner')
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.customers.destroy', [$vehicle, $vehicle->customer]) }}">
					@csrf
					@method('DELETE')
					<button class="btn-outline-red">Eliminar</button>
				</form>
			@endslot

			<div class="flex">
				<div class="w-1/2">
					@component('components.table')
						@slot('items', [
							'Empresa' => $vehicle->customer->enterprise->name,
							'Nombre' => $vehicle->customer->name,
							'Contacto' => $vehicle->customer->contact1,
							'Email' => $vehicle->customer->email1,
							'Teléfono' => $vehicle->customer->phone1,
							'Dirección' => $vehicle->customer->fulladdress,
						])
					@endcomponent
				</div>
				<div class="w-1/2">
					<fieldset>
						<legend>Clientes anteriores</legend>
						@foreach($vehicle->customerHistory as $history)
							<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) bg-green-200 text-green-800 @endif">
								<div class="w-1/2">
									<span>
										{{$history->customer->enterprise->name}}
										&middot;
										{{$history->customer->name}}
									</span>
								</div>
								<div class="w-1/2">{{$history->created_at->format('d/m/y H:i:s')}}</div>
							</div>
						@endforeach
					</fieldset>
				</div>
			</div>
		@endcomponent
	@endif
@endsection
