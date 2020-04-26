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
				<td>
					<a class="font-medium hover:underline" href="{{ route('fleet.vehicles.show', $alert->vehicle) }}">
						{{ $alert->vehicle->plate }} {{ $alert->vehicle->chassis }}
					</a>
				</td>
				<td title="{{ $alert->created_at->format('d/m/Y H:i:s') }}">{{ $alert->created_at->diffForHumans() }}</td>
				<td>
					<div class="flex items-center">
						@if(!$alert->dismissed)
							@if($alert->action_url)
								<a href="{{ route('alert.linking', $alert) }}" class="mr-4">
									<i class="fas fa-tools"></i>
								</a>
							@endif

							<form method="POST" action="{{ route('fleet.alerts.update', $alert) }}">
								@csrf
								@method('PUT')
								<input type="hidden" name="dismissed" value="1">
								<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Descartar</button>
							</form>
						@endif
					</div>
				</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $alerts->appends(request()->query())->links() }}
@endsection
