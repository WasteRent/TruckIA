@extends('layouts.admin')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	
	{{ session('garage')->name ?? '' }}	

	<br>

	{{ session('vehicle')->plate ?? '' }}	
	
	<div>
		<div class="bg-white p-4" @click="modalGarages = true">
			Seleccionar Taller
		</div>

		<br>

		<div class="bg-white p-4" @click="modalVehicles = true">
			Seleccionar Vehículo
		</div>
	</div>

	<card-modal :showing="modalVehicles" >
		<p slot="header">Seleccionar vehículo</p>
		<vehicle-selector></vehicle-selector>
	</card-modal>

	<card-modal :showing="modalGarages" >
		<p slot="header">Título bonico</p>
		<garage-selector></garage-selector>
	</card-modal>

	@if(session('garage') && session('vehicle'))
	<form action="{{ route('admin.repair-orders.store') }}" method="POST">
		@csrf
		<input type="hidden" name="vehicle_id" value="{{ session('vehicle')->id }}">
		<input type="hidden" name="garage_id" value="{{ session('garage')->id }}">
		<button>Crear OR</button>
	</form>
	@endif


@endsection
