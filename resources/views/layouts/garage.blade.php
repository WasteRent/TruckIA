@extends('layouts.master', ['banner' => Auth::user()->garage->hourly_price == 0, 'banner_content' => 'Debes configurar tú mano de obra en el área de datos personales!'])

@section('app')
	@include('shared.alerts')

	@section('nav-items')
	{{
		json_encode([
			[
				'name' => 'Trabajo pendiente',  
				'icon' => '<i class="fas fa-home mr-2 w-4"></i>', 
				'link' => route('garage.dashboard'), 
				'active' => request()->is('garage/dashboard*'),
			],
			[
				'name' => 'Alertas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('garage.alerts.index'), 
				'active' => request()->is('garage/alerts*'),
				'badge' => Auth::user()->garage->alerts()->pending()->count(),
			],
			[
				'name' => 'Citas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('garage.appointments.index'),
				'active' => request()->is('garage/appointments*'),
				'badge' => Auth::user()->garage->appointments()->pending()->count(),
				'end_section' => true
			],
			[
				'name' => 'Ordenes de Reparación',  
				'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
				'link' => route('garage.repair-orders.index'),
				'active' => request()->is('garage/repair-orders*'),
			],
			[
				'name' => 'Vehículos',  
				'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
				'link' => route('garage.vehicles.index'),
				'active' => request()->is('garage/vehicles*'),
				'end_section' => true
			],
			[
				'name' => 'Datos generales',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('garage.details.index'),
				'active' => false
			]
		])
	}}
	@endsection

	@yield('progress')

	<main>@yield('content')</main>
@endsection
