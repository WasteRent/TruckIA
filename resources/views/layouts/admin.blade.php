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
			<div class="flex items-center py-2 {{ request()->is('admin/alerts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bell mr-2 w-4 {{ request()->is('admin/alerts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.alerts.index') }}" class="mr-1">Alertas</a>
				<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">3</div>
			</div>

			<div class="py-3"></div>

			<div class="flex items-center py-2 {{ request()->is('admin/repair-orders*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-paste mr-2 w-4 {{ request()->is('admin/repair-orders*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.repair-orders.index') }}">Ordenes de Reparación</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/operations*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-cogs mr-2 w-4 {{ request()->is('admin/operations*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.operations.index') }}">Operaciones</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/maintenance-plans*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-layer-group mr-2 w-4 {{ request()->is('admin/maintenance-plans*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.maintenance-plans.index') }}">Planes de Mantenimiento</a>
			</div>
				
			<div class="py-3"></div>
			
			<div class="flex items-center py-2 {{ request()->is('admin/spare-parts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-wrench mr-2 w-4 {{ request()->is('admin/spare-parts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.spare-parts.index') }}">Recambios</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/vehicles*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bus-alt mr-2 w-4 {{ request()->is('admin/vehicles*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.vehicles.index') }}">Vehículos</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/garage*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-warehouse mr-2 w-4 {{ request()->is('admin/garage*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.garages.index') }}">Talleres</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/fleets*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-campground mr-2 w-4 {{ request()->is('admin/fleets*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.fleets.index') }}">Flotas</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/customers*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-user-tag mr-2 w-4 {{ request()->is('admin/customers*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.customers.index') }}">Clientes</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/users*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-users mr-2 w-4 {{ request()->is('admin/users*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.users.index') }}">Usuarios</a>
			</div>

			<div class="py-3"></div>

			<div class="py-2">
				<div class="flex items-center">
					<i class="icon fas fa-cog mr-2 w-4"></i>
					<span>Configuración</span>
				</div>
				<div class="ml-6 mt-2">
					<a href="{{ route('admin.families.index') }}">Familias</a>
				</div>
				<div class="ml-6 mt-2">
					<a href="{{ route('admin.manufacturers.index') }}">Marcas</a>
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
