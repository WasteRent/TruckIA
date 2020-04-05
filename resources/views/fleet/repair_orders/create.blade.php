@extends('layouts.fleet')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	<div>
		<div class="bg-white hover:cursor-pointer px-6 py-4 shadow rounded flex mb-8" @click="modalVehicles = true">
			<div class="w-1/12"><i class="fas fa-bus fa-lg mr-3"></i></div>
			<div class="w-11/12">
				<span class="font-bold tracking-wid mr-3">1. Seleccionar Vehículo</span>
			</div>
			<div><i class="fas fa-chevron-right"></i></div>
		</div>

		@if(session('vehicle'))
			@include('shared.vehicles.show', ['vehicle' => session('vehicle')])
		@endif

		<hr class="my-8">

		<div class="bg-white hover:cursor-pointer px-6 py-4 shadow rounded flex mb-8" @click="modalGarages = true">
			<div class="w-1/12"><i class="fas fa-warehouse fa-lg mr-3"></i></div>
			<div class="w-11/12">
				<span class="font-bold tracking-wid mr-3">2. Seleccionar Taller</span>
			</div>
			<div><i class="fas fa-chevron-right"></i></div>
		</div>

		@if(session('garage'))
			@include('shared.garages.show', ['garage' => session('garage')])
		@endif
	</div>

	<card-modal :showing="modalVehicles">
		<p slot="header">Seleccionar Vehículo</p>
		<vehicle-selector></vehicle-selector>
	</card-modal>

	<card-modal :showing="modalGarages">
		<p slot="header">Seleccionar Taller</p>
		<garage-selector></garage-selector>
	</card-modal>

	@if(session('garage') && session('vehicle'))
	<div class="py-3 text-center"> 
		<form action="{{ route('fleet.repair-orders.store') }}" method="POST">
			@csrf
			<input type="hidden" name="vehicle_id" value="{{ session('vehicle')->id }}">
			<input type="hidden" name="garage_id" value="{{ session('garage')->id }}">

			<div class="w-1/4">
				<label class="form-label" >
				  Tipo de Mantenimiento
				</label>
				  {!! Form::select('type', ['corrective' => 'Correctivo','preventive' => 'Preventivo','pre-itv' => 'Pre-ITV'], request()->query('type'), ['class' => 'form-select']) !!}
			</div>

			<button class="btn-indigo">Crear Order de Reparación</button>
		</form>
	</div>
	@endif


@endsection
