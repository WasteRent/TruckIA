@extends('layouts.admin')

@section('content')

	@include('admin.vehicles.edit_tabs', ['active_customers' => true])

	@component('components.search-card')
		@include('admin.customers.search', ['route' => ['admin.vehicles.customers.index', $vehicle]])
	@endcomponent

	@if(count($customers_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar cliente')

			<table class="table-auto w-full">
			  <thead class="uppercase text-xs font-bold tracking-wide">
			    <tr class="bg-gray-100 border-t border-b">
			      <td class="px-6 py-2">Nombre</td>
			      <td class="px-6 py-2">Email</td>
			      <td class="px-6 py-2">Tel.</td>
			      <td class="px-6 py-2">Dirección</td>
			      <td class="px-6 py-2"></td>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($customers_search as $customer)
			  	<tr class="border-t border-b text-gray-700">
			  	  <td class="px-6 py-2">{{$customer->name}}</td>
			  	  <td class="px-6 py-2">{{$customer->email}}</td>
			  	  <td class="px-6 py-2">{{$customer->phone}}</td>
			  	  <td class="px-6 py-2">{{$customer->full_address}}</td>
			  	  <td class="px-6 py-2 flex">
		  	  		<form method="POST" action="{{ route('admin.vehicles.customers.store', $vehicle) }}">
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
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('admin.vehicles.customers.destroy', [$vehicle, $vehicle->customer]) }}">
					@csrf
					@method('DELETE')
					<button><i class="icon fas fa-trash-alt"></i></button>
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
