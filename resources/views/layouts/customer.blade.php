@extends('layouts.master')

@section('app')
	@include('shared.alerts')

	@section('nav-items')
	{{
		json_encode([
			[
				'name' => 'Inicio',  
				'icon' => '<i class="fas fa-home mr-2 w-4"></i>', 
				'link' => '', 
				'active' => request()->is('*dashboard*')
			],
			[
				'name' => 'Alertas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('customer.alerts.index', ['filter' => 'today']),
				'active' => request()->is('customer/alerts*'),
				'badge' => Auth::user()->customer->alerts()->pending()->count()
			],
			[
				'name' => 'Citas',  
				'icon' => '<i class="fas fa-calendar-alt mr-2 w-4"></i>', 
				'link' => route('customer.appointments.index'),
				'active' => request()->is('customer/appointments*'),
				'badge' => Auth::user()->customer->appointments()->pending()->count()
			],
			[
				'name' => 'Mantenimiento',  
				'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
				'link' => route('customer.preventives.index'),
				'active' => request()->is('customer/preventives*')
			],
			[
				'name' => 'Vehículos',  
				'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
				'link' => route('customer.vehicles.index'),
				'active' => request()->is('customer/vehicles*'),
				'end_section' => true
			],
			[
				'name' => 'Configuración',  
				'icon' => '<i class="fas fa-user-cog mr-2 w-4"></i>', 
				'link' => route('customer.details.index'),
				'active' => request()->is('customer/details*')
			]
		])
	}}
	@endsection

	@yield('progress')

	<main>@yield('content')</main>
@endsection