@extends('layouts.fleet')

@section('title', __('KPIs'))

@section('content')

	<div>
	  <h3 class="text-lg leading-6 font-medium text-gray-900">
	    {{$total}} {{ __('vehículos') }}
	  </h3>
	  <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
	    @foreach($vehicles as $vehicle)
	    <a href="{{ route('fleet.vehicles.index', ['state_id' => $vehicle['id']]) }}">
		    <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
		      <dt class="text-sm font-medium text-gray-500 truncate">
		        {{ $vehicle['state'] }}
		      </dt>
		      <dd class="mt-1 text-3xl font-semibold text-gray-900 flex justify-between">
		        <span>{{ $vehicle['count'] }}</span>
		        <div>
		        	<span class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 md:mt-2 lg:mt-0">{{ $vehicle['percent'] }}%</span>
		        </div>
		      </dd>
		    </div>
		</a>
	    @endforeach


	  </dl>
	</div>


	<br><br>
	<div>
	  <h3 class="text-lg leading-6 font-medium text-gray-900">
	    {{ __('Mantenimiento') }}
	  </h3>
	  <small class="text-gray-500">* Vehículo alquilados</small>

	  <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
	  	<div class="relative bg-white pt-5 px-4 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
	  	  <dt>
	  	    <div class="absolute bg-green-500 rounded-md p-3">
	  	      <i class="fas fa-check-circle text-white"></i>
	  	    </div>
	  	    <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ __('Al día') }}</p>
	  	  </dt>
	  	  <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
	  	    <p class="text-2xl font-semibold text-gray-900">
	  	    	{{ $maintenance->where('state', 'Al día')->count() }}
	  	    </p>
	  	    <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
	  	      	{{ number_format($maintenance->where('state', 'Al día')->count() / $maintenance->count() * 100, 2) }}%
	  	    </p>
	  	  </dd>
	  	</div>

	    <div class="relative bg-white pt-5 px-4 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
	      <dt>
	        <div class="absolute bg-red-500 rounded-md p-3">
	          <i class="fas fa-exclamation-triangle text-white"></i>
	        </div>
	        <p class="ml-16 text-sm font-medium text-gray-500 truncate">{{ __('Pasado') }}</p>
	      </dt>
	      <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
	        <p class="text-2xl font-semibold text-gray-900">
	          	{{ $maintenance->where('state', 'Pasado')->count() }}
	        </p>
	        <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
	        	{{ number_format($maintenance->where('state', 'Pasado')->count() / $maintenance->count() * 100, 2)  }}%
	        </p>
	      </dd>
	    </div>
	  </dl>
	</div>


@endsection
