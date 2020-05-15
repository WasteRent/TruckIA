@extends('layouts.customer')

@section('title', 'Reporte de Accidentes ' . $vehicle->plate . " " . $vehicle->chassis)

@section('content')
	
	@component('components.card', ['is_table' => true])
		@slot('corner')
			<a href="{{ route('customer.vehicles.accident-reports.create', $vehicle) }}" class="btn-outline-gray flex items-center">
				<i class="icon fas fa-plus-circle mr-2"></i>
				Nuevo
			</a>
		@endslot
		
		<table >
		  <thead >
		    <tr >
		      <th>Resumen</th>
		      <th>Archivo</th>
		      <th>Fecha</th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->accident_reports as $report)
		  	<tr >
		  	  <td>{{ $report->summary }}</td>
		  	  <td>
		  	  	<a href="{{ $report->file->getLink() }}" target="_blank">
		  	  		<i class="fas fa-cloud-download-alt"></i>
		  	  	</a>
		  	  </td>
		  	  <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent
@endsection
