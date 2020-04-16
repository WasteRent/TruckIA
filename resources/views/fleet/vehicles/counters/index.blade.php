@extends('layouts.fleet')

@section('content')
		
	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card', ['is_table' => true])
		@slot('title', 'Contadores')
		<table>
		  <thead>
		    <tr>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters as $counter)
		  	<tr>
		  	  <td>{{ $counter->current }}</td>
		  	  <td>{{ $counter->max }} {{ $counter->type == 'hours' ? 'H':'kms' }}</td>
		  	  <td></td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

@endsection