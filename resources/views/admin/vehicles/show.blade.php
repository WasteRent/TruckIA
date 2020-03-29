@extends('layouts.admin')

@section('content')
	
	@include('shared.vehicles.show', ['vehicle' => $vehicle])

	@include('shared.vehicles.repair_orders', ['vehicle' => $vehicle])

	@component('components.card')
		@slot('title', 'Archivos')

		<ul>
		@foreach($vehicle->files as $file)
			<li>
				<a class="mr-2" target="_blank" href="{{ $file->getLink() }}"><i class="fas fa-cloud-download-alt"></i></a>
				<span>{{ $file->description }}</span>
			</li>
		@endforeach
		</ul>
		
	@endcomponent

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
		@slot('title', 'Averías Reportadas')

		@foreach($vehicle->failures()->orderByDesc('created_at')->get() as $failure)
			<div class="pb-4 flex items-center">
				<div class="w-1/12">&middot;</div>
				<div class="w-3/12">{{ $failure->created_at->format('d/m/Y H:i:s')}}</div>
				<div class="w-8/12">
					<p>{{ $failure->type->name }}</p>
					<small class="text-gray-700">{{ $failure->observations }}</small>
				</div>
			</div>
		@endforeach
	@endcomponent

	@component('components.card')
		@slot('title', 'Alertas')

		@foreach($vehicle->alerts()->orderByDesc('created_at')->get() as $alert)
			<div class="pb-4 flex items-center">
				<div class="w-1/12"><i class="fas fa-exclamation-triangle text-orange-500"></i></div>
				<div class="w-3/12">{{ $alert->created_at->format('d/m/Y H:i:s')}}</div>
				<div class="w-8/12">
					<p>{{ $alert->title }}</p>
					<small class="text-gray-700">{{ $alert->description }}</small>
				</div>
			</div>
		@endforeach
	@endcomponent

@endsection
