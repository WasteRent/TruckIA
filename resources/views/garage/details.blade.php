@extends('layouts.garage')

@section('content')
	
	@component('components.card')
		@slot('title', 'Datos del Taller')

		{!! Form::model($garage, [
			'route' => ['garage.details.update'],
			'method' => 'PUT',
			'class' => 'w-full'
		]) !!}	
			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Nombre
			    </label>
			    {!! Form::text('name', null, ['class' => 'form-input']) !!}
			  </div>
			</div>

			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Email
			    </label>
			    {!! Form::email('email', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Teléfono
			    </label>
			    {!! Form::text('phone', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Horario de apertura
			    </label>
			    {!! Form::text('opening_hours', null, ['class' => 'form-input']) !!}
			  </div>
			</div>


			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-3/5 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Dirección
			    </label>
			    {!! Form::text('address', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Localidad
			    </label>
			    {!! Form::text('state', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Provincia
			    </label>
			    {!! Form::text('province', null, ['class' => 'form-input']) !!}
			  </div>
			</div>

			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Código Postal
			    </label>
			    {!! Form::text('zip', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Latitud
			    </label>
			    {!! Form::text('latitude', null, ['class' => 'form-input']) !!}
			  </div>
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Longitud
			    </label>
			    {!! Form::text('longitude', null, ['class' => 'form-input']) !!}
			  </div>
			</div>

			<div class="flex flex-wrap -mx-3 mb-6">
			  <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
			    <label class="form-label">
			      Precio M.O
			    </label>
			    {!! Form::number('hourly_price', null, ['class' => 'form-input', 'step' => '0.01']) !!}
			  </div>
			</div>

			<div class="flex justify-end">
				<button class="px-4 py-1 rounded text-white bg-indigo-600 shadow flex items-center">Guardar</button>
			</div>
		{!! Form::close() !!}
	@endcomponent

@endsection