@extends('layouts.garage')

@section('title', 'Nueva Orden de Reparación')

@section('content')
	<div>
		<vehicle-selector></vehicle-selector>
		@if(session('vehicle'))
			@include('shared.vehicles.show', ['vehicle' => session('vehicle')])
		@endif
	</div>


	@if(session('vehicle'))
	<div class="py-3 text-center"> 
		<form action="{{ route('garage.repair-orders.store') }}" method="POST">
			@csrf
			<input type="hidden" name="vehicle_id" value="{{ session('vehicle')->id }}">
			<button class="btn-indigo">
			  Crear Order de Reparación
			</button>
		</form>
	</div>
	@endif


@endsection
