@extends('layouts.fleet')

@section('title', __('Tareas pendientes'))

@section('content')
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
	                      <strong class="mx-1.5">{{$order->assigned->fullname}}</strong>
	                      <img loading="lazy" class="-mt-2 h-8 w-8 rounded-full inline-block object-cover" src="{{ optional($order->assigned->avatar)->getLink() }}" alt="">
	                    </span>
	                  @endif
	              </div>
	              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">{{ $order->state->name }}</span>
	            </div>
	            <div class="mt-4 sm:flex sm:justify-between">
	              <div class="sm:flex">
	                <p class="flex items-center text-sm text-gray-500">
	                	<i class="text-gray-400 fas fa-car mr-1.5"></i>
	                	{{ optional($order->vehicle)->plate }}
	                	&middot;
	                	{{ optional($order->vehicle)->chassis }}
	                	&middot;
	                	{{ optional($order->vehicle)->equipment }}
	                </p>
	                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-3">
	                  	<i class="fas fa-warehouse text-gray-400 mr-1.5"></i>
	                	{{ optional($order->garage)->name }}
	                </p>
	              </div>
	              <div class="mt-2 flex items-center text-xs text-gray-500 sm:mt-0">
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
@endsection
