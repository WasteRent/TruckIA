@php
	$enlaces[] =
		[
			'name' => __('Trabajo pendiente'),
			'icon' => '<i class="fas fa-home mr-2 w-4"></i>',
			'link' => route('garage.home'),
			'active' => request()->is('garage/dashboard*'),
			'disponible' => true
		];

	/*$enlaces[] =
		[
			'name' => __('Alertas'),
			'icon' => '<i class="fas fa-bell mr-2 w-4"></i>',
			'link' => route('garage.alerts.index'),
			'active' => request()->is('garage/alerts*'),
			'badge' => Auth::user()->garage->alerts()->pending()->count(),
			'disponible' => true
		];*/

	$enlaces[] =
		[
			'name' => 'Ordenes de Reparación',
			'icon' => '<i class="fas fa-paste mr-2 w-4"></i>',
			'link' => route('garage.repair-orders.index'),
			'active' => request()->is('garage/repair-orders*'),
			'disponible' => true
		];

		/*
	$enlaces[] =
		[
			'name' => 'Vehículos',
			'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>',
			'link' => route('garage.vehicles.index'),
			'active' => request()->is('garage/vehicles*'),
			'end_section' => true,
			'disponible' => true
		];

	$enlaces[] =
		[
			'name' => 'Datos generales',
			'icon' => '<i class="fas fa-cog mr-2 w-4"></i>',
			'link' => route('garage.details.index'),
			'active' => false,
			'disponible' => true
		];*/
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
