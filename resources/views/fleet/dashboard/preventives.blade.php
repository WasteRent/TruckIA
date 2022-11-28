@extends('layouts.fleet')

@section('title', __('Preventivos'))

@section('content')

	@component('components.search-card')
		{!! 
			Form::model(count(request()->all()) > 0 ? request()->all() : session('filters'), [
				'route' => 'fleet.dashboard.preventives', 
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
	
	<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	@foreach($vehicles as $vehicle) 	
		<div class="bg-white overflow-hidden shadow rounded-lg">
		  <div class="px-4 pt-5">
			<div class="flex justify-between">
				<div class="text-2xl font-semibold text-gray-900">
					<a href="{{ route('fleet.vehicles.show', $vehicle) }}">{{ $vehicle->plate }}</a>
					<div class="text-xs text-gray-800">
						<span class="px-2 py-0.5 bg-blue-100 rounded-full">
							@if ($vehicle->assigned_customer_id)
								<a href="{{ route('fleet.customers.edit', $vehicle->assigned_customer_id )  }}">
									{{ optional($vehicle->customer)->name }}
								</a>
							@endif
							</span>
						<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
							<p class="mt-2">{{ $vehicle->chassis }}</p>
							<p>{{ $vehicle->equipment }}</p>
						</a>
					</div>
				</div>
				<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
					<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($vehicle->getCover())->getLink() }}">
				</a>
			</div>
				
			<fieldset>
				<legend>{{ __('Chasis') }}</legend>
				<div class="pb-3">
					@forelse ($vehicle->counters()
							->where('vehicle_category', 'chassis')
							->get()
							->filter
							->isThresholdReached()
							->sortByDesc('completedPercent') as $counter)
					    @include('fleet.vehicles.counters.progress')
					@empty
					    <p class="text-green-700 flex items-center text-xs">
					    	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
					    	  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
					    	</svg>
					    	Mantenimiento realizado recientemente
					    </p>
					@endforelse
				</div>
			</fieldset>
			
			<fieldset>
				<legend>{{ __('Equipos') }}</legend>
				<div class="pb-3">
					@forelse ($vehicle->counters()
							->where('vehicle_category', 'equipment')
							->get()
							->filter
							->isThresholdReached()
							->sortByDesc('completedPercent') as $counter)
					    @include('fleet.vehicles.counters.progress')
					@empty
					    <p class="text-green-700 flex items-center text-xs">
					    	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
					    	  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
					    	</svg>
					    	Mantenimiento realizado recientemente
					    </p>
					@endforelse
				</div>
			</fieldset>

			<div class="text-right text-xs text-blue-800 pt-4 pb-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $vehicle) }}"><i class="far fa-eye"></i>&nbsp;{{ __('Ficha') }}</a>
				<span class="p-1 border border-blue-700 text-blue-700 rounded-sm rounded-lg"><a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}"><i class="p-1 fas fa-plus"></i>{{ __('Crear O.R.') }}</a></span>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
