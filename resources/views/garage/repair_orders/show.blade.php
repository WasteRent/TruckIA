@extends('layouts.garage')

@section('content')

	@component('components.card')
		@slot('title', 'Orden de Reparación')
		@component('components.table')
			@slot('items', [
				'ID' => $repair_order->id,
				'Fecha' => $repair_order->created_at->format('d/m/Y H:i:s'),
				'Observaciones' => $repair_order->remarks,
			])
		@endcomponent
	@endcomponent
	
	@include('shared.vehicles.show', ['vehicle' => $repair_order->vehicle])

	@component('components.card')
		@slot('title', 'Operaciones')
		@foreach($repair_order->operations->groupBy('family_id') as $operations)
			<h1 class="font-medium">{{ $operations->first()->family->name }}</h1>
			<ul class="text-sm">
				@foreach($operations as $operation)
					<li class="pl-4 text-gray-600 flex items-center">
						<i class="fas fa-chevron-right fa-xs mr-2"></i>
						{{ $operation->name }}
					</li>
				@endforeach
			</ul>
		@endforeach

		<div class="text-center">
			<a href="{{ route('garage.show.operation', [$repair_order, $repair_order->operations->first()]) }}" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
			  Comenzar
			</a>
		</div>
	@endcomponent

@endsection
