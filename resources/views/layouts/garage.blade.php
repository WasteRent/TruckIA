@extends('layouts.master')

@section('app')
<div class="pt-4 pb-10 flex items-center justify-between">
	<img class="w-32" src="https://truckts.com/img/logos/truckts_logo.png">
	<div class="flex items-center">
		<span class="text-sm mr-2">{{ Auth::user()->name }}</span>
		<form method="POST" action="{{ route('logout') }}">
			@csrf
			<button><i class="fas fa-power-off"></i></button>
		</form>
	</div>
</div>

<div class="flex">
	<div class="w-1/6 mr-8">
		<div class="text-sm">
			<div class="flex items-center py-2">
				<i class="fas fa-home mr-2 w-4"></i>
				<a href="">Inicio</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('garage/alerts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bell mr-2 w-4 {{ request()->is('garage/alerts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.alerts.index') }}" class="mr-1">Alertas</a>
				<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">3</div>
			</div>

			<div class="py-3"></div>
			
			<div class="flex items-center py-2 {{ request()->is('garage/repair-orders*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-paste mr-2 w-4 {{ request()->is('garage/repair-orders*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.repair-orders.index') }}">Ordenes de reparación</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('garage/vehicles*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bus-alt mr-2 w-4 {{ request()->is('garage/vehicles*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.vehicles.index') }}">Vehículos</a>
			</div>

			<div class="py-3"></div>

			<div class="flex items-center py-2 {{ request()->is('garage/details*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-user-cog mr-2 w-4 {{ request()->is('garage/details*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.details.index') }}">Datos</a>
			</div>
		
		</div>
	</div>

	<div class="w-full">
		@include('shared.alerts')

		@yield('progress')
		
		<div class="text-2xl font-light mb-3">
			@yield('title')
		</div>

		<main id="app">@yield('content')</main>
		<br><br>
	</div>
</div>
@endsection