@extends('layouts.fleet')

@section('title', __('Tareas pendientes'))

@section('content')

@component('components.card')
{!! 
	Form::model(request()->all(), [
		'method' => 'GET',
		'class' => ['md:flex items-center']
	])
!!}
    <div class="lg:px-3 lg:mb-0 mb-3">
      	<label class="form-label">{{ __('Matrícula') }}</label>
    	{!! Form::text('plate', null, ['placeholder' => 'Ej: 9820JVP', 'class' => 'form-input']) !!}
    </div>
    <div class="lg:px-3 lg:mb-0 mb-3">
      <label class="form-label">
        {{ __('Usuario') }}
      </label>
      {!! Form::select('assigned_user_id', $users->pluck('name', 'id')->prepend('', ''), request()->query('assigned_user_id') ? request()->query('assigned_user_id'):auth()->id(), ['class' => 'form-select']) !!}
    </div>
    <div class="text-right">
    	<button class="btn-search">
        <i class="fas fa-search"></i>
      </button>
    </div>
{!! Form::close() !!}
@endcomponent


<div class="grid grid-cols-3 gap-4">
	<div class="col-span-2">
		<div class="bg-white shadow overflow-hidden sm:rounded-md">
		  <ul class="divide-y divide-gray-200">
		    @foreach($repair_orders as $order)
		      <li>
		        <a href="{{ route('fleet.repair-orders.show', $order) }}" class="block hover:bg-gray-50">
		          <div class="px-4 py-4 sm:px-6">
		            <div class="flex items-center justify-between">
		              <div class="flex text-sm">
		                  <span class="font-medium text-blue-web mr-1.5">#O.R. {{ $order->id }}</span>
		                  @if ($order->assigned)
		                    <span class="text-gray-500 font-light flex">
		                      asignado a 
		                      <strong class="mx-1.5">{{$order->assigned->name}}</strong>
		                      
		                    </span>
		                  @endif
		              </div>
		              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $order->state->color }}">{{ $order->state->name }}</span>
		            </div>
		            <div class="mt-4 sm:flex sm:justify-between">
		              <div class="sm:flex">
		                <p class="flex items-center text-sm text-gray-500 truncate">
		                	<i class="text-gray-400 fas fa-car mr-1.5"></i>
		                	{{ optional($order->vehicle)->plate }}
		                	&middot;
		                	{{ optional($order->vehicle)->chassis }}
		                	&middot;
		                	{{ optional($order->vehicle)->equipment }}
		                </p>
		                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-3 truncate">
		                  	<i class="fas fa-warehouse text-gray-400 mr-1.5"></i>
		                	{{ optional($order->garage)->name }}
		                </p>
		              </div>
		              <div class="ml-4 mt-2 flex items-center text-xs text-gray-500 sm:mt-0">
		                <p>
		                  @if($order->creator)
		                    Creado por <strong>{{ $order->creator->name }}</strong>
		                  @endif
		                  <time datetime="{{ $order->created_at }}">{{ $order->created_at->diffForHumans() }}</time>
		                </p>
		              </div>
		            </div>
		          </div>
		        </a>
		      </li>
		    @endforeach
		  </ul>
		</div>
	</div>
	<div class="col-span-1">
		@component('components.card', ['is_table' => true])
			@slot('title')
				<div class="flex items-center">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					  <path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
					</svg>
					<span>{{ __('Incidencias abiertas') }} <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-red-500 text-white">{{ $incidents->count() }}</span></span>
				</div>
			@endslot
			<ul role="list" class="divide-y divide-gray-200">
				@foreach($incidents as $incident)
				  <li class="py-2 px-3">
				      <p class="text-xs text-gray-900">{!! $incident->incidence !!}</p>
				      <p class="text-xs text-gray-500">{{ $incident->vehicle->plate }} {{ $incident->vehicle->chassis }}</p>
				  </li>
				@endforeach
			</ul>
		@endcomponent


	</div>
</div>
@endsection
