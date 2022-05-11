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
				
			<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
				<fieldset>
					<legend>{{ __('Chasis') }}</legend>
					<div class="pb-3">
						@foreach($vehicle->counters()
								->where('vehicle_category', 'chassis')
								->get()
								->filter
								->isThresholdReached()
								->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
				
				<fieldset>
					<legend>{{ __('Equipos') }}</legend>
					<div class="pb-3">
						@foreach($vehicle->counters()
								->where('vehicle_category', 'equipment')
								->get()
								->filter
								->isThresholdReached()
								->sortByDesc('completedPercent') as $counter)
							@include('fleet.vehicles.counters.progress')
						@endforeach
					</div>
				</fieldset>
			</a>

			<div class="text-right text-xs text-blue-800 pt-4 pb-2">
				<a class="mr-3" href="{{ route('fleet.vehicles.show', $vehicle) }}"><i class="far fa-eye"></i>&nbsp;{{ __('Ficha') }}</a>
				<span class="p-1 border border-blue-700 text-blue-700 rounded-sm rounded-lg"><a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}"><i class="p-1 fas fa-plus"></i>{{ __('Crear O.R.') }}</a></span>
			</div>
	
		  </div>
		</div>
	@endforeach
	</div>

@endsection
