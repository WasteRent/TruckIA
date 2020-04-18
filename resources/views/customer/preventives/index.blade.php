@extends('layouts.customer')

@section('title', 'Mantenimiento Preventivo')

@section('content')

	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Pendientes',
				'url' => '?completed=0',
				'active' => empty(request()->query('completed'))
			],
			[
				'name' => 'Completados',
				'url' => '?completed=1',
				'active' => request()->query('completed') == '1'
			]
		]
	])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table >
		  <thead >
		    <tr >
		      <th>Nombre</th>
		      <th>Matrícula</th>
		      <th>Vehículo</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($preventives as $preventive)
		  	<tr >
		  	  <td>{{ $preventive->name }}</td>
		  	  <td>{{ $preventive->vehicle->plate }}</td>
		  	  <td>{{ $preventive->vehicle->chassis }} {{ $preventive->vehicle->box }}</td>
		  	  <td>{{ $preventive->created_at->format('d/m/Y H:i:s') }}</td>
		  	  <td>
		  	  	<a href="{{ route('customer.preventives.show', $preventive) }}"  class="mr-3">
		  	  		<i class="icon fas fa-eye"></i>
		  	  	</a>
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
