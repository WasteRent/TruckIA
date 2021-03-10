@extends('layouts.fleet')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	<div>
		<vehicle-selector endpoint="/api/vehicle/search"></vehicle-selector>
		@if(session('vehicle'))
			@include('shared.vehicles.show', ['vehicle' => session('vehicle'), 'show_counters' => true])
		@endif

		<hr class="my-8">

		<garage-selector endpoint="/api/garage/search?vehicle_id={{optional(session('vehicle'))->id}}"></garage-selector>
		@if(session('garage'))
			@include('shared.garages.show', ['garage' => session('garage')])
		@endif
	</div>

	@if(session('garage') && session('vehicle'))
	<div class="py-3 text-center"> 
		<form action="{{ route('fleet.repair-orders.store') }}" method="POST">
			@csrf
			<input type="hidden" name="vehicle_id" value="{{ session('vehicle')->id }}">
			<input type="hidden" name="garage_id" value="{{ session('garage')->id }}">

			<div class="lg:w-1/4 mb-6 lg:mb-0">
				<label class="form-label" >
				  Tipo de Mantenimiento
				</label>
				@if(Auth::user()->fleet->module_ITV)
				  {!! Form::select('type', ['preventive' => 'Preventivo','corrective' => 'Correctivo','pre-itv' => 'Pre-ITV'], request()->query('type'), ['class' => 'form-select']) !!}
				@else
				  {!! Form::select('type', ['preventive' => 'Preventivo','corrective' => 'Correctivo'], request()->query('type'), ['class' => 'form-select']) !!} 
				@endif
			</div>

			<button class="btn-indigo">Crear Orden de Reparación</button>
		</form>
	</div>
	@endif


@endsection
