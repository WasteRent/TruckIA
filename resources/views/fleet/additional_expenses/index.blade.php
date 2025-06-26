@extends('layouts.fleet')

@section('title', __('Carga de gastos'))

@section('content')

	@component('components.search-card')
		@include('fleet.additional_expenses.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.additional-vehicle-expenses', request()->query()) }}"><i class="fas fa-lg fa-file-excel"></i></a>
			<a href="{{ route('fleet.additional-vehicle-expenses.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
			<th>{{ __('Vehículo') }}</th>
		      <th>{{ __('ID vehículo') }}</th>
		      <th>{{ __('Fecha') }}</th>
		      <th>{{ __('Concepto') }}</th>
		      <th>{{ __('Proveedor') }}</th>
			  <th>{{ __('Cantidad') }}</th>
			  <th>{{ __('Precio unitario') }}</th>
			  <th>{{ __('Importe') }}</th>
			  <th>{{ __('Centro') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($additional_vehicle_expenses as $additional_vehicle_expense)
		  	<tr>
				<td>{{ $additional_vehicle_expense->vehicle?->plate }}</td>
				<td>{{ $additional_vehicle_expense->vehicle?->internal_id }}</td>
				<td>{{ Carbon\Carbon::parse($additional_vehicle_expense->date)->format('d/m/Y') }}</td>
				<td>{{ $additional_vehicle_expense->description }}</td>
				<td>{{ $additional_vehicle_expense->supplier ?? 'Sin asignar' }}</td>
				<td>{{ $additional_vehicle_expense->quantity ?? 'Sin asignar' }}</td>
				<td>{{ number_format($additional_vehicle_expense->unit_price, 2, ',') ?? 'Sin asignar' }}&euro;</td>
				<td>{{ number_format($additional_vehicle_expense->amount, 2, ',') }}&euro;</td>
				<td>{{ $additional_vehicle_expense->customer->enterprise->name ?? 'Sin asignar' }}</td>
				@if(in_array(auth()->user()->job, ['fleet_manager']))
					<td>
						<form class method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.additional-vehicle-expenses.destroy', $additional_vehicle_expense) }}">
							@csrf
							@method('DELETE')
							<button><i class="icon fas fa-trash-alt"></i></button>
						</form>
					</td>
				@endif
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $additional_vehicle_expenses->appends(request()->query())->links() }}
@endsection
