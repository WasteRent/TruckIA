@extends('layouts.fleet')

@section('title', __('Extintores'))

@section('content')

	@include('fleet.dashboard.tabs2', ['fleet' => true])

	@component('components.search-card')
		{!! 
			Form::model(count(request()->all()) > 0 ? request()->all() : session('filters'), [
				'route' => 'fleet.dashboard.extinguisher', 
				'method' => 'GET',
				'class' => ['sm:flex flex-wrap']
			])
		!!}
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      	<label class="form-label">{{ __('Matrícula') }}</label>
		    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
		    </div>
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      <label class="form-label">
		        {{ __('Marca chasis') }}
		      </label>
		        {!! Form::select('chassis_maker_id', $chassis_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('chassis_maker_id', 'chassis_model_id', '/api/manufacturer/{id}/models')"]) !!}
		    </div>
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      <label class="form-label">
		        {{ __('Modelo chasis') }}
		      </label>
		        {!! Form::select('chassis_model_id', $chassis_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
		    </div>
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      <label class="form-label">
		        {{ __('Marca equipo') }}
		      </label>
		        {!! Form::select('equipment_maker_id', $equipment_manufacturers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select', 'onchange' => "ajaxSelect('equipment_maker_id', 'equipment_model_id', '/api/manufacturer/{id}/models')"]) !!}
		    </div>
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      <label class="form-label">
		        {{ __('Modelo equipo') }}
		      </label>
		        {!! Form::select('equipment_model_id', $equipment_models->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
		    </div>
		    <div class="lg:px-3 sm:w-2/12 lg:mb-0 mb-3">
		      <label class="form-label">
		        {{ __('Estado') }}
		      </label>
		        {!! Form::select('state_id', $states->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
		    </div>
		    <div class="lg:px-3 sm:w-3/12 lg:mb-0 my-3">
		      <label class="form-label">
		        {{ __('Cliente') }}
		      </label>
		        {!! Form::select('assigned_customer_id', $customers->pluck('name', 'id')->prepend('', ''), null, ['class' => 'form-select']) !!}
		    </div>
		    <div class="text-right">
		        <button class="btn-search">
		          <i class="fas fa-search"></i>
		        </button>
		    </div>
		{!! Form::close() !!}
	@endcomponent

	<br>

	<div class=""> 
		<h3 class="text-lg leading-6 font-medium text-gray-900">
			{{ __('Próximas') }}
		</h3>
	</div>
	
		@foreach($comming->groupBy(function($i) {
			return Carbon\Carbon::parse($i->estinguishers()->orderBy('expiration_date')->first()->expiration_date)->format('M-Y');
		}) as $month => $vehicles)
			<div class="mt-4 text-indigo-800 font-medium">
				{{ $month }}
			</div>
			<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
				@foreach($vehicles as $vehicle)
					@include('fleet.dashboard.extinguisher_card')
				@endforeach
			</div>
		@endforeach

	<div class="mt-8">
		<h3 class="text-lg leading-6 font-medium text-gray-900">
			{{ __('Caducadas') }}
		</h3>
	</div>
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
		@foreach($expired as $vehicle) 	
			@include('fleet.dashboard.extinguisher_card')
		@endforeach
	</div>

@endsection
