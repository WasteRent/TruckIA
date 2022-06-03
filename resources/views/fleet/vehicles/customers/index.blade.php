@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_customers' => true])

	@component('components.search-card')
		@include('fleet.customers.search', ['route' => ['fleet.vehicles.customers.index', $vehicle]])
	@endcomponent

	@if(count($customers_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', __('Seleccionar cliente'))

			<table>
			  <thead>
			    <tr>
			      <th>{{ __('Nombre') }}</th>
			      <th>{{ __('Email') }}</th>
			      <th>{{ __('Tel.') }}</th>
			      <th>{{ __('Dirección') }}</th>
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
			@slot('title')
				{{ __('Cliente actual') }}
				@if($vehicle->customer)
				<a class="btn-outline-gray" href="{{ route('fleet.customers.edit', $vehicle->customer) }}">{{ __('Ver') }}</a>
				@endif
			@endslot
			@slot('corner')
				<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.customers.destroy', [$vehicle, $vehicle->customer]) }}">
					@csrf
					@method('DELETE')
					<button class="btn-outline-red">{{ __('Eliminar') }}</button>
				</form>
			@endslot

			<div class="sm:flex">
				<div class="sm:w-1/2">
					@component('components.table')
						@slot('items', [
							__('Empresa') => $vehicle->customer->enterprise->name,
							__('Nombre') => $vehicle->customer->name,
							__('Contacto') => $vehicle->customer->contact1,
							__('Email') => $vehicle->customer->email1,
							__('Teléfono') => $vehicle->customer->phone1,
							__('Dirección') => $vehicle->customer->fulladdress,
						])
					@endcomponent
				</div>
				<div class="sm:w-1/2 mt-4 sm:mt-0">
					<fieldset>
						<legend>{{ __('Clientes anteriores') }}</legend>
						@foreach($vehicle->customerHistory as $history)
							<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) bg-green-200 text-green-800 @endif">
								<div class="w-1/2">
									@if($history->customer)
									<a href="{{ route('fleet.customers.edit', $history->customer) }}">
										{{$history->customer->enterprise->name ?? ''}}
										&middot;
										{{$history->customer->name ?? ''}}
									</a>
									@endif
								</div>
								<div class="w-1/2">{{$history->created_at->format('d/m/y H:i:s')}}</div>
							</div>
						@endforeach
					</fieldset>
				</div>
			</div>
		@endcomponent
	@else
		@component('components.card')
		<div class="sm:flex">
			<div class="sm:w-1/2">
				{{ __('No hay ningún cliente asignado') }}
			</div>
			<div class="sm:w-1/2 mt-4 sm:mt-0">
				<fieldset>
					<legend>{{ __('Clientes anteriores') }}</legend>
					@foreach($vehicle->customerHistory as $history)
						<div class="flex my-1 px-2 py-1 rounded text-xs @if($loop->first) bg-green-200 text-green-800 @endif">
							<div class="w-1/2">
								<span>
									{{$history->customer->enterprise->name ?? ''}}
									&middot;
									{{$history->customer->name ?? ''}}
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


	@component('components.card', ['is_table' => true])
		@slot('title', __('Albaranes de entrega'))
		@slot('corner')
			<a href="{{ route('fleet.vehicles.deliveries.create', $vehicle) }}" class="btn-outline-gray">{{ __('Nuevo') }}</a>
		@endslot

		<table>
		  <thead>
		    <tr>
		      <th>{{ __('Nombre') }}</th>
		      <th>{{ __('Tipo') }}</th>
		      <th>{{ __('Fecha') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->deliveries as $delivery)
		  	<tr>
		  	  <td>#{{ $delivery->id }}</td>
		  	  <td>{{ $delivery->type }}</td>
		  	  <td>{{ $delivery->date }}</td>
		  	  <td></td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
