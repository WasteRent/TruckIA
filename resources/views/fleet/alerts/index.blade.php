@extends('layouts.fleet')

@section('title', __('Alertas'))

@section('content')
	
	@component('components.search-card')
		@include('fleet.alerts.search', ['route' => 'fleet.alerts.index'])
	@endcomponent

	<div class="my-3">
		@foreach(App\Models\AlertType::all() as $type)
			@if($type->pending()->where('fleet_id', Auth::user()->fleet->id)->count() > 0)
				<a href="?type_id={{$type->id}}">
					<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">{{ $type->name }} ({{ $type->pending()->where('fleet_id', Auth::user()->fleet->id)->count() }})</span>
				</a>
			@endif
		@endforeach
	</div>

	@component('components.card', ['is_table' => true])
		<table>
		  <thead>
		    <tr>
		      <th>{{ __('Alerta') }}</th>
		      <th>{{ __('Descripción') }}</th>
		      <th>{{ __('Vehículo') }}</th>
		      <th>{{ __('Fecha') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($alerts as $alert)
		  	<tr>
				<td class="{{ $alert->dismissed ? '' : 'text-indigo-600' }}">{{ $alert->title }}</td>
				<td class="{{ $alert->dismissed ? '' : 'text-indigo-600' }}">{{ $alert->description }}</td>
				<td class="{{ $alert->dismissed ? '' : 'text-indigo-600' }}">
					<a class="font-medium hover:underline" href="{{ route('fleet.vehicles.show', $alert->vehicle) }}">
						{{ $alert->vehicle->plate }} {{ $alert->vehicle->chassis }}
					</a>
				</td>
				<td class="{{ $alert->dismissed ? '' : 'text-indigo-600' }}" title="{{ $alert->created_at->format('d/m/Y H:i:s') }}">{{ $alert->created_at->diffForHumans() }}</td>
				<td>
					<div class="flex items-center">
						@if($alert->action_url)
							<a href="{{ route('alert.linking', $alert) }}" class="mr-4">
								<i class="fas fa-tools fa-lg"></i>
							</a>
						@endif	
							
						@if(!$alert->dismissed)
							<form method="POST" action="{{ route('fleet.alerts.update', $alert) }}">
								@csrf
								@method('PUT')
								<input type="hidden" name="dismissed" value="1">
								<button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">{{ __('Descartar') }}</button>
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
