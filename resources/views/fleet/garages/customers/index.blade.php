@extends('layouts.fleet')

@section('title', 'Talleres')

@section('content')

    @include('fleet.garages.tabs', ['active_customers' => true])

	@component('components.search-card')
		@include('fleet.garages.customers.search', ['route' => ['fleet.garages.customers.index', $garage]])
	@endcomponent

	@if(count($customers_search) > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Seleccionar cliente')
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
              @foreach($customers_search as $customer)
              <tr>
                <td>{{$customer->name}} </td>
                <td>{{$customer->email1}}</td>
                <td>{{$customer->phone1}}</td>
                <td>{{$customer->full_address}}</td>
			  	      <td>
		  	  		    <form method="POST" action="{{ route('fleet.garages.customers.store', $garage) }}">
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

	@if($customers->count() > 0)
		@component('components.card', ['is_table' => true])
			@slot('title', 'Clientes asignados')
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
                <td><a class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline" href="{{ route('fleet.customers.edit', $customer) }}">{{$customer->name}} </a></td>
                <td>{{$customer->email1}}</td>
                <td>{{$customer->phone1}}</td>
                <td>{{$customer->full_address}}</td>
                <td>
                  <form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.garages.customers.destroy', [$garage, $customer]) }}">
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
	@endif
@endsection
