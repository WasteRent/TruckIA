@extends('layouts.fleet')

@section('title', __('Carga de gastos'))

@section('content')

	@component('components.search-card')
		@include('fleet.additional_expenses.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('fleet.additional-vehicle-expenses.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
			<th>{{ __('ID Vehículo') }}</th>
		      <th>{{ __('Fecha') }}</th>
		      <th>{{ __('Vehículo') }}</th>
		      <th>{{ __('Concepto') }}</th>
		      <th>{{ __('Importe') }}</th>
			  <th>{{ __('Centro') }}</th>
			  <th>{{ __('Proveedor') }}</th>
			  <th>{{ __('Cantidad') }}</th>
			  <th>{{ __('Precio unitario') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($expenses as $expense)
		  	<tr>
				<td>{{ $expense->vehicle?->id }}</td>
				<td>{{ Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
				<td>{{ $expense->vehicle_reference }}</td>
				<td>{{ $expense->description }}</td>
				<td>{{ number_format($expense->amount, 2, ',') }}&euro;</td>
				<td>{{ $expense->customer->enterprise->name ?? 'Sin asignar' }}</td>
				<td>{{ $expense->supplier ?? 'Sin asignar' }}</td>
				<td>{{ $expense->quantity ?? 'Sin asignar' }}</td>
				<td>{{ number_format($expense->unit_price, 2, ',') ?? 'Sin asignar' }}&euro;</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $expenses->appends(request()->query())->links() }}
@endsection
