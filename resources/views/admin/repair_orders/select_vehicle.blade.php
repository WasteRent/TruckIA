@extends('layouts.admin')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	
	{{ session('garage') }}	
	
	<div>
		<div class="bg-white p-4" @click="modalVehicles = true">
			Seleccionar Vehículo
		</div>

		<br>

		<div class="bg-white p-4" @click="modalGarages = true">
			Seleccionar Taller
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

@endsection
