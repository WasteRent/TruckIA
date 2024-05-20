@php
	$enlaces = [
			[
				'name' => 'Inicio',  
				'icon' => '<i class="fas fa-home mr-2 w-4"></i>', 
				'link' => '', 
				'active' => request()->is('*dashboard*')
			],
			/*[
				'name' => 'Alertas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('customer.alerts.index'),
				'active' => request()->is('customer/alerts*'),
				'badge' => Auth::user()->customer->alerts()->pending()->count()
			],
			[
				'name' => 'Mantenimiento',  
				'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
				'link' => route('customer.preventives.index'),
				'active' => request()->is('customer/preventives*')
			],*/
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
	];
@endphp



@extends('layouts.master', ['nav_items' => $enlaces])

@section('app')
	@include('shared.alerts')

	@yield('progress')

	<main>
		@yield('content')

		<br><br><br>
	</main>
@endsection