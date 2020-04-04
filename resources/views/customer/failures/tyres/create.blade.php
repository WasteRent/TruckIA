@extends('layouts.customer')

@section('content')
	
	@component('components.card')
		@slot('title', 'Reportar estado de neumáticos - ' . $vehicle->fullname)

		{!! Form::open([
			'route' => ['customer.tyre-failure.store', $vehicle],
			'method' => 'POST',
			'class' => 'w-full'
		]) !!}

		<div class="flex flex-wrap -mx-3 mb-6">
		  <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
		      <label class="form-label" >
		        Avería
		      </label>
		        {!! Form::select('failure', [
		        	'Chasis primer eje' => 'Chasis primer eje',
		        	'Chasis segundo eje' => 'Chasis segundo eje',
		        	'Chasis tercer eje' => 'Chasis tercer eje',
		        	'Barredora delanteras' => 'Barredora delanteras',
		        	'Barredora traseras' => 'Barredora traseras',
		        	'Otros (especificar)' => 'Otros (especificar)',
		        ], null, ['class' => 'form-select']) !!}
		  </div>

		  
		</div>

		<div class="flex flex-wrap -mx-3 mb-6">
		  <div class="w-full px-3 mb-6 md:mb-0">
		    <label class="form-label">
		      Observaciones
		    </label>
		    {!! Form::textarea('observations', null, ['class' => 'form-input']) !!}
		  </div>
		</div>



		<div class="flex justify-end">
			<button class="btn-indigo">Guardar</button>
		</div>
		{!! Form::close() !!}
	@endcomponent

@endsection