@extends('layouts.admin')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

	@include('shared.vehicles.operations', ['vehicle' => $vehicle])

	@component('components.card')
		@slot('title', 'Alertas')

		@foreach($vehicle->alerts()->orderByDesc('created_at')->get() as $alert)
			<div class="pb-4 flex items-center">
				<div class="w-1/12"><i class="fas fa-exclamation-triangle text-orange-500"></i></div>
				<div class="w-3/12">{{ $alert->created_at->format('d/m/Y H:i:s')}}</div>
				<div class="w-8/12">{{ $alert->description }}</div>
			</div>
		@endforeach
	@endcomponent

@endsection
