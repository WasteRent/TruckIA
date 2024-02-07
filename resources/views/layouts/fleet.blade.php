@php
	$enlaces[] =
		[
			'name' => __('Dashboard'),  
			'icon' => '<i class="fas fa-tachometer-alt mr-2 w-4"></i>', 
			'link' => route('fleet.kpis.index'), 
			'active' => request()->is('*kpis*'),
			'disponible' => true
		];
	$enlaces[] =
		[
			'name' => __('Tareas pendientes'),  
			'icon' => '<i class="fas fa-tasks mr-2 w-4"></i>', 
			'link' => route('fleet.pending.index'), 
			'active' => request()->is('*pending*'),
			'badge' => Auth::user()->pendingTasksCount(),
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
			'name' => __('Mi calendario'),
			'icon' => '<i class="fas fa-calendar mr-2 w-4"></i>', 
			'link' => route('fleet.calendar.index'), 
			'active' => request()->is('*calendar*'),
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
			'name' => __('Ordenes de Reparación'),  
			'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
			'link' => route('fleet.repair-orders.index'),
			'active' => request()->is('fleet/repair-orders*'),
			'disponible' => true
		];
	$enlaces[] =
	[
		'name' => __('Incidencias'),  
		'icon' => '<i class="fas fa-exclamation-triangle mr-2 w-4"></i>', 
		'link' => route('fleet.incidents.index'), 
		'active' => request()->is('fleet/incidents*'),
		'badge' => App\Models\VehicleIncident::whereNull('closed_at')->whereHas('vehicle', function($q) {
			$q->where('fleet_id', Auth::user()->fleet->id);
		})->count(),
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
			'name' => __('Contenedores'),  
			'icon' => '<i class="fas fa-box mr-2 w-4"></i>', 
			'link' => route('fleet.containers.index'),
			'active' => request()->is('fleet/containers*'),
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
			'name' => __('Recambios'),
			'icon' => '<i class="fas fa-cogs mr-2 w-4"></i>',
			'link' => route('fleet.spare-parts.index'),
			'active' => request()->is('fleet/spare-parts*'),
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
			'disponible' => Auth::user()->job == 'fleet_manager'
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
	if(in_array(Auth::user()->id, [3,920, 929,872,637, 928,955,904])) {
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
