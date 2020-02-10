@extends('layouts.admin')

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Creada por' => $repair_order->creator->name,
				'Autorizada por' => $repair_order->authorizer ? $repair_order->authorizer->name : '', 
				'Completada' => $repair_order->finished_at ? 'Si':'No',
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@include('shared.garages.show', ['garage' => $repair_order->garage])

	@component('components.card')
		@slot('title', 'Operaciones')
		@foreach($repair_order->operations as $operation)
			<div class="text-gray-700 py-1">
				{{ $operation->code }} &middot; {{ $operation->name }}
				<p class="text-sm text-gray-600">{{ $operation->description }}</p>
			</div>
			<div class="flex items-center pt-1 pb-3 mb-3 border-b">
				@if($operation->pivot->completed)
					<i class="fas fa-check fa-xs text-green-600 mr-1"></i>

					<span class="text-xs text-gray-600 mr-2">
						{{ Carbon\Carbon::parse($operation->pivot->completed_at)->format('d/m/Y H:i:s') }}
					</span>

					@if($operation->pivot->file)
						<a href="{{ Storage::url('truckts/mantenimientos/operaciones/'.$operation->pivot->file) }}">
							<i class="fas fa-cloud-download-alt"></i>
						</a>
					@endif
				@else	
					<i class="fas fa-exclamation-circle fa-xs text-red-600 mr-1"></i>
				@endif
			</div>
		@endforeach
	@endcomponent

@endsection
