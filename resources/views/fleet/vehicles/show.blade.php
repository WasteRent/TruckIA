@extends('layouts.fleet')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

	@include('shared.vehicles.repair_orders', ['vehicle' => $vehicle])

	@component('components.card')
		@slot('title', 'Estado')
		
		<div class="flex">
			<div class="text-center">
				<h1 class="font-medium">Estado</h1>
				<img class="" src="{{ asset('img/p.png') }}">
			</div>
			<div class="text-center">
				<h1 class="font-medium">Desgaste</h1>
				<img class="" src="{{ asset('img/cu.png') }}">
			</div>
		</div>
		<br><br>
		<div>
			<i class="icon fas fa-cloud-download-alt"></i>
			<a href="{{ asset('img/demo.oxps') }}">demo.oxps</a>
		</div>

	@endcomponent

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
