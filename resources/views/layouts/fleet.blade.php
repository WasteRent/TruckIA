@extends('layouts.master')

@section('app')
	@include('shared.alerts')

	@section('nav-items')
	@php 
	$enlaces[] =
			[
				'name' => 'Preventivos',  
				'icon' => '<i class="fas fa-tachometer-alt mr-2 w-4"></i>', 
				'link' => route('fleet.dashboard.preventives'), 
				'active' => request()->is('*preventives*'),
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'ITV',  
				'icon' => '<i class="fas fa-digital-tachograph mr-2 w-4"></i>', 
				'link' => route('fleet.dashboard.itv'), 
				'active' => request()->is('*itv*'),
				'disponible' => Auth::user()->fleet->module_ITV
			];
	$enlaces[] =
			[
				'name' => 'Alertas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('fleet.alerts.index'), 
				'active' => request()->is('fleet/alerts*'),
				'badge' => Auth::user()->fleet->alerts()->pending()->count(),
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Ordenes de Reparación',  
				'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
				'link' => route('fleet.repair-orders.index', ['state_id' => 1]),
				'active' => request()->is('fleet/repair-orders*'),
				'end_section' => true,
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Vehículos',  
				'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
				'link' => route('fleet.vehicles.index'),
				'active' => request()->is('fleet/vehicles*'),
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Talleres',  
				'icon' => '<i class="fas fa-warehouse mr-2 w-4"></i>', 
				'link' => route('fleet.garages.index'),
				'active' => request()->is('fleet/garage*'),
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Clientes',  
				'icon' => '<i class="fas fa-user-tag mr-2 w-4"></i>', 
				'link' => route('fleet.customers.index'),
				'active' => request()->is('fleet/customers*'),
				'end_section' => true,
				'disponible' => Auth::user()->fleet->module_customers
			];
	$enlaces[] =
			[
				'name' => 'Usuarios',  
				'icon' => '<i class="fas fa-users mr-2 w-4"></i>', 
				'link' => route('fleet.users.index'),
				'active' => request()->is('fleet/users*'),
				'end_section' => true,
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Grupos empresariales',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('fleet.enterprise-groups.index'),
				'active' => false,
				'disponible' => true
			];
	$enlaces[] =
			[
				'name' => 'Datos generales',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('fleet.details.index'),
				'active' => false,
				'disponible' => true
			];

		foreach ($enlaces as $key => $enlace){
			if(!$enlace['disponible'] ){
				unset($enlaces[$key]);
			}
		}
		if(Auth::user()->id === 3){
	$enlaces[] =
			[
				'name' => 'Marcas y Modelos',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('fleet.manufacturers.index'),
				'active' => false
			];
	$enlaces[] =
			[
				'name' => 'Planes de mantenimiento',  
				'icon' => '<i class="fas fa-layer-group mr-2 w-4"></i>', 
				'link' => route('fleet.maintenance-plans.index'), 
				'active' => request()->is('fleet/maintenance-plans*')
			];
		}

		$enlaces = json_encode($enlaces);
	@endphp

	{{  $enlaces }}
	
	@endsection

	@yield('progress')

	<main>
		@yield('content')
		
		<br><br><br>
	</main>
@endsection
