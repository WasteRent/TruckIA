@php
	$enlaces[] =
		[
			'name' => __('Actividad'),  
			'icon' => '<i class="fas fa-broadcast-tower mr-2 w-4"></i>', 
			'link' => route('fleet.feed.index'), 
			'active' => request()->is('*feed*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('KPI'),  
			'icon' => '<i class="fas fa-tachometer-alt mr-2 w-4"></i>', 
			'link' => route('fleet.kpis.index'), 
			'active' => request()->is('*kpis*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Preventivos'),  
			'icon' => '<i class="fas fa-code-branch mr-2 w-4"></i>', 
			'link' => route('fleet.dashboard.preventives'), 
			'active' => request()->is('*preventives*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('ITV'),  
			'icon' => '<i class="fas fa-digital-tachograph mr-2 w-4"></i>', 
			'link' => route('fleet.dashboard.itv'), 
			'active' => request()->is('*itv*'),
			'disponible' => Auth::user()->fleet->module_ITV,
			'end_section' => true
		];
	$enlaces[] =
		[
			'name' => __('Incidencias'),  
			'icon' => '<i class="fas fa-exclamation-triangle mr-2 w-4"></i>', 
			'link' => route('fleet.incidents.index'), 
			'active' => request()->is('fleet/incidents*'),
			'badge' => App\Models\VehicleIncident::whereNull('closed_at')->count(),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Alertas'),  
			'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
			'link' => route('fleet.alerts.index'), 
			'active' => request()->is('fleet/alerts*'),
			'badge' => Auth::user()->fleet->alerts()->pending()->count(),
			'disponible' => true,
			'end_section' => true
		];
	$enlaces[] =
		[
			'name' => __('Ordenes de Reparación'),  
			'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
			'link' => route('fleet.repair-orders.index'),
			'active' => request()->is('fleet/repair-orders*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Vehículos'),  
			'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
			'link' => route('fleet.vehicles.index'),
			'active' => request()->is('fleet/vehicles*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Talleres'),  
			'icon' => '<i class="fas fa-warehouse mr-2 w-4"></i>', 
			'link' => route('fleet.garages.index'),
			'active' => request()->is('fleet/garage*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Clientes'),  
			'icon' => '<i class="fas fa-user-tag mr-2 w-4"></i>', 
			'link' => route('fleet.customers.index'),
			'active' => request()->is('fleet/customers*'),
			'end_section' => true,
			'disponible' => Auth::user()->fleet->module_customers
		];
	$enlaces[] =
		[
			'name' => __('Usuarios'),  
			'icon' => '<i class="fas fa-users mr-2 w-4"></i>', 
			'link' => route('fleet.users.index'),
			'active' => request()->is('fleet/users*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Grupos empresariales'),  
			'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
			'link' => route('fleet.enterprise-groups.index'),
			'active' => false,
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Datos generales'),  
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
	if(in_array(Auth::user()->id, [3,920, 929,872])) {
		$enlaces[] =
				[
					'name' => __('Marcas y Modelos'),  
					'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
					'link' => route('fleet.manufacturers.index'),
					'active' => false
				];
		$enlaces[] =
				[
					'name' => __('Planes de mantenimiento'),  
					'icon' => '<i class="fas fa-layer-group mr-2 w-4"></i>', 
					'link' => route('fleet.maintenance-plans.index'), 
					'active' => request()->is('fleet/maintenance-plans*')
				];
	}
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
