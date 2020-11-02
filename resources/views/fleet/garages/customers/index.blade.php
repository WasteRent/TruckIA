@extends('layouts.fleet')

@section('title', 'Talleres')

@section('content')

    @include('fleet.garages.tabs', ['active_customers' => true])

    @component('components.card', ['is_table' => true])
    
		<table>
		  <thead>
		    <tr>
		      <th>Nombre</th>
		      <th>Email</th>
		      <th>Tel.</th>
              <th >Dirección</th>
              <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($customers as $customer)
		  	<tr>
                <td>{{$customer->name}} </td>
                <td>{{$customer->email1}}</td>
                <td>{{$customer->phone1}}</td>
                <td>{{$customer->address}}</td>
                <td>
                    <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.garage.customers.destroy', [$garage, $customer]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-outline-red">Eliminar</button>
                    </form>
                </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection
