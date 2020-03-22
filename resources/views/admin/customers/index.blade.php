@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')

	@component('components.search-card')
		@include('admin.customers.search', ['route' => 'admin.customers.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('admin.customers.create') }}" class="border px-4 py-1 rounded hover:bg-gray-100 shadow flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th>Email</th>
		      <th>Tel.</th>
		      <th>Dirección</th>
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
		  	  	<a href="{{ route('admin.customers.edit', $customer) }}" class="mr-2">
		  	  		<i class="icon fas fa-edit"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $customers->appends(request()->query())->links() }}
@endsection
