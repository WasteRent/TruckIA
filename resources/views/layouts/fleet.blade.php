@extends('layouts.master')

@section('app')

@include('shared.head')

<div class="flex">
	<div class="w-1/6 mr-8">
		<div class="text-sm">
			<div class="flex items-center py-2">
				<i class="fas fa-home mr-2 w-4"></i>
				<a href="">Inicio</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('fleet/alerts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bell mr-2 w-4 {{ request()->is('fleet/alerts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('fleet.alerts.index') }}" class="mr-1">Alertas</a>
				@if(Auth::user()->alerts()->count())
					<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">
						{{Auth::user()->alerts()->count()}}
					</div>
				@endif
			</div>

			<div class="py-3"></div>
			
			<div class="flex items-center py-2 {{ request()->is('fleet/repair-orders*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-paste mr-2 w-4 {{ request()->is('fleet/repair-orders*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('fleet.repair-orders.index') }}">Ordenes de Reparación</a>
			</div>

			<div class="py-3"></div>
				
			<div class="flex items-center py-2 {{ request()->is('fleet/vehicles*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bus-alt mr-2 w-4 {{ request()->is('fleet/vehicles*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('fleet.vehicles.index') }}">Vehículos</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('fleet/garage*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-warehouse mr-2 w-4 {{ request()->is('fleet/garage*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('fleet.garages.index') }}">Talleres</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('fleet/customers*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-user-tag mr-2 w-4 {{ request()->is('fleet/customers*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('fleet.customers.index') }}">Clientes</a>
			</div>


			<div class="py-3"></div>

			<div class="py-2">
				<div class="flex items-center">
					<i class="icon fas fa-cog mr-2 w-4"></i>
					<span>Configuración</span>
				</div>
				<div class="ml-6 mt-2">
					<a href="{{ route('fleet.details.index') }}">Datos</a>
				</div>
				<div class="ml-6 mt-2">
					<a href="{{ route('fleet.enterprise-groups.index') }}">Empresas</a>
				</div>
				<div class="ml-6 mt-2">
					<a href="{{ route('fleet.manufacturers.index') }}">Marcas y Modelos</a>
				</div>
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
