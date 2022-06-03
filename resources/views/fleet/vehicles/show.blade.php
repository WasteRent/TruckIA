@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.warranty-banner')
	
	@include('fleet.vehicles.tracking')

	@include('shared.vehicles.show', ['vehicle' => $vehicle])

	@include('fleet.vehicles.counters.show')

	@component('components.card')
		@slot('title', __('Gasto de mantenimiento'))
		
		@include('fleet.vehicles.expense')
	@endcomponent

	@if($vehicle->repairOrders()->count() > 0)
		@include('shared.vehicles.repair_orders', ['vehicle' => $vehicle])
	@endif

	@if($vehicle->files->count() > 0)
		@component('components.card')
			@slot('title', __('Archivos'))

			<ul>
			@foreach($vehicle->files as $file)
				<li>
					<a class="mr-2" target="_blank" href="{{ $file->getLink() }}"><i class="fas fa-cloud-download-alt"></i></a>
					<span>{{ $file->description }}</span>
				</li>
			@endforeach
			</ul>
		@endcomponent
	@endif

	@if($vehicle->accident_reports()->count() > 0)
		@component('components.card')
			@slot('title', __('Accidentes reportados'))

			@foreach($vehicle->accident_reports()->latest()->get() as $report)
				<div class="pb-4 flex items-center">
					<div class="w-1/12">&middot;</div>
					<div class="w-3/12">{{ $report->created_at->format('d/m/Y H:i:s')}}</div>
					<div class="w-8/12">
						<p>{{ $report->summary }}</p>
						<a href="{{ $report->file->getLink() }}" target="_blank">
							<i class="fas fa-cloud-download-alt"></i> {{ __('Descargar') }}
						</a>
					</div>
				</div>
			@endforeach
		@endcomponent
	@endif

	@if($vehicle->failures()->count() > 0)
		@component('components.card')
			@slot('title', __('Averías reportadas'))

			@foreach($vehicle->failures()->latest()->get() as $failure)
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
	@endif


	@if($vehicle->alerts()->count() > 0)
		@component('components.card')
			@slot('title', __('Alertas'))

			@foreach($vehicle->alertsNotDailyOrWeekly()->orderByDesc('created_at')->get() as $alert)
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
	@endif

@endsection
