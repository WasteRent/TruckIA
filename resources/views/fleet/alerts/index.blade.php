@extends('layouts.fleet')

@section('title', 'Alertas')

@section('content')
	
	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Hoy',
				'url' => route('fleet.alerts.index', ['filter' => 'today']),
				'active' => request()->query('filter') == 'today'
			],
			[
				'name' => 'Todas',
				'url' => route('fleet.alerts.index', ['filter' => 'all']),
				'active' => request()->query('filter') == 'all'
			]
		]
	])
	@endcomponent

	@component('components.search-card')
		@include('fleet.alerts.search', ['route' => 'fleet.alerts.index'])
	@endcomponent

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>Alerta</th>
		      <th>Descripción</th>
		      <th>Vehículo</th>
		      <th>Fecha</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($alerts as $alert)
		  	<tr >
				<td>{{ $alert->title }}</td>
				<td>{{ $alert->description }}</td>
				<td>{{ $alert->vehicle->plate }} {{ $alert->vehicle->chassis }}</td>
				<td title="{{ $alert->created_at->format('d/m/Y H:i:s') }}">{{ $alert->created_at->diffForHumans() }}</td>
				<td>
					@if(!$alert->dismissed)
						<form method="POST" action="{{ route('fleet.alerts.update', $alert) }}">
							@csrf
							@method('PUT')
							<input type="hidden" name="dismissed" value="1">
							<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Descartar</button>
						</form>
					@endif
				</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $alerts->appends(request()->query())->links() }}
@endsection
