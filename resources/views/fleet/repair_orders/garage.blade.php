@extends('layouts.fleet')

@include('fleet.repair_orders.tabs', ['active_garage' => true])

@section('content')
	
	@include('shared.garages.show', ['garage' => $repair_order->garage])

	@if(in_array(Auth::user()->job, ['fleet_manager']))
		@if(!$repair_order->isFinished())
		<div class="w-1/2">
			{!! 
				Form::open([
					'route' => ['fleet.repair-orders.update', $repair_order], 
					'method' => 'PUT',
					'class' => ['md:flex items-center']
				])
			!!}

				{!! Form::select('garage_id', $garages->pluck('name', 'id'), $repair_order->garage->id, ['class' => 'form-select js-select-search']) !!}

				<div class="ml-2 text-right">
					<button class="btn-outline-gray">
					Cambiar
				</button>
				</div>
			{!! Form::close() !!}
		</div>
		@endif
	@endif

@endsection
