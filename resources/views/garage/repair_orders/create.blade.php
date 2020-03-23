@extends('layouts.garage')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	<div>
		<div class="bg-white hover:cursor-pointer px-6 py-4 shadow rounded flex mb-8" @click="modalVehicles = true">
			<div class="w-1/12"><i class="fas fa-bus fa-lg mr-3"></i></div>
			<div class="w-11/12">
				<span class="font-bold tracking-wid mr-3">Seleccionar Vehículo</span>
			</div>
			<div><i class="fas fa-chevron-right"></i></div>
		</div>

		@if(session('vehicle'))
			@include('shared.vehicles.show', ['vehicle' => session('vehicle')])
		@endif

	</div>

	<card-modal :showing="modalVehicles">
		<p slot="header">Seleccionar Vehículo</p>
		<vehicle-selector></vehicle-selector>
	</card-modal>


	@if(session('vehicle'))
	<div class="py-3 text-center"> 
		<form action="{{ route('garage.repair-orders.store') }}" method="POST">
			@csrf
			<input type="hidden" name="vehicle_id" value="{{ session('vehicle')->id }}">
			<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
			  Crear Order de Reparación
			</button>
		</form>
	</div>
	@endif


@endsection
