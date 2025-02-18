@extends('layouts.fleet')

@section('title', __('Clientes'))

@section('content')

	@component('components.search-card')
		@include('fleet.customers.search', ['route' => 'fleet.customers.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a class="mr-4 text-green-600" href="{{ route('fleet.export.customers') }}"><i class="fas fa-lg fa-file-excel"></i></a>
			@if(!Auth::user()->hasRole('fleet'))
			<a href="{{ route('fleet.customers.create') }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				{{ __('Nuevo') }}
			</a>
			@endif
		@endslot
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
		  	@foreach($customers as $customer)
		  	<tr>
		  		<td>{{$customer->name}} </td>
		  		<td>{{$customer->email1}}</td>
		  		<td>{{$customer->phone1}}</td>
				<td>{{$customer->full_address}}</td>
		  	  	<td>
					<div class="flex">
						<a href="{{ route('fleet.customers.edit', $customer) }}" class="mr-3">
							<i class="icon fas fa-edit"></i>
						</a>
						@if(!Auth::user()->hasRole('fleet'))
						<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.customers.destroy', $customer) }}">
							@csrf
							@method('DELETE')
							<button><i class="icon fas fa-trash-alt"></i></button>
						</form>
						@endif
					</div>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $customers->appends(request()->query())->links() }}
@endsection
