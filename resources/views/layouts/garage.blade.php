@extends('layouts.master', ['banner' => Auth::user()->garage->hourly_price == 0, 'banner_content' => 'Debes configurar tú mano de obra en el área de datos personales!'])

@section('app')

@include('shared.head')

<div class="flex">
	<div class="w-1/6 mr-8">
		<div class="text-sm">
			<div class="flex items-center py-2">
				<i class="fas fa-home mr-2 w-4"></i>
				<a href="">Inicio</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('garage/alerts*') ? 'text-indigo-600':'' }}">
				<i class="fas fa-bell mr-2 w-4 {{ request()->is('garage/alerts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.alerts.index', ['filter' => 'today']) }}" class="mr-1">Alertas</a>
				@if(Auth::user()->garage->alerts()->pending()->count())
					<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">
						{{Auth::user()->garage->alerts()->pending()->count()}}
					</div>
				@endif
			</div>
			<div class="flex items-center py-2 {{ request()->is('garage/appointments*') ? 'text-indigo-600':'' }}">
				<i class="fas fa-calendar-alt mr-2 w-4 {{ request()->is('garage/appointments*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.appointments.index') }}" class="mr-1">Citas</a>

				@if(Auth::user()->garage->appointments()->pending()->count())
					<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">
						{{Auth::user()->garage->appointments()->pending()->count()}}
					</div>
				@endif
			</div>

			<div class="py-3"></div>
			
			<div class="flex items-center py-2 {{ request()->is('garage/repair-orders*') ? 'text-indigo-600':'' }}">
				<i class="fas fa-paste mr-2 w-4 {{ request()->is('garage/repair-orders*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.repair-orders.index') }}">Ordenes de reparación</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('garage/vehicles*') ? 'text-indigo-600':'' }}">
				<i class="fas fa-bus-alt mr-2 w-4 {{ request()->is('garage/vehicles*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.vehicles.index') }}">Vehículos</a>
			</div>

			<div class="py-3"></div>

			<div class="flex items-center py-2 {{ request()->is('garage/details*') ? 'text-indigo-600':'' }}">
				<i class="fas fa-user-cog mr-2 w-4 {{ request()->is('garage/details*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('garage.details.index') }}">Datos</a>
			</div>
		
		</div>
	</div>

	<div class="w-5/6">
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