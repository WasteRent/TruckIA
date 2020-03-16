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
		  	@foreach($customers as $customer)
		  	<tr class="border-t border-b text-gray-700">
		  	  <td class="px-6 py-2">{{$customer->name}} </td>
		  	  <td class="px-6 py-2">{{$customer->email1}}</td>
		  	  <td class="px-6 py-2">{{$customer->phone1}}</td>
		  	  <td class="px-6 py-2">{{$customer->full_address}}</td>
		  	  <td class="px-6 py-2 flex">
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
