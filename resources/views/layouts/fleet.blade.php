@php
	$enlaces[] =
		[
			'name' => __('Dashboard'),  
			'icon' => '<i class="fas fa-tachometer-alt mr-2 w-4"></i>', 
			'link' => route('fleet.kpis.index'), 
			'active' => request()->is('*kpis*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic', 'garage'])
		];
	$enlaces[] =
		[
			'name' => __('Tareas pendientes'),  
			'icon' => '<i class="fas fa-tasks mr-2 w-4"></i>', 
			'link' => route('fleet.pending.index'), 
			'active' => request()->is('*pending*'),
			'badge' => Auth::user()->pendingTasksCount(),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'mechanic'])
		];
	$enlaces[] =
		[
			'name' => __('Preventivos'),  
			'icon' => '<i class="fas fa-code-branch mr-2 w-4"></i>', 
			'link' => route('fleet.dashboard.preventives'), 
			'active' => request()->is('*preventives*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic', 'garage'])
		];
	$enlaces[] =
		[
			'name' => __('Mi calendario'),
			'icon' => '<i class="fas fa-calendar mr-2 w-4"></i>', 
			'link' => route('fleet.calendar.index'), 
			'active' => request()->is('*calendar*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'mechanic'])
		];
	$enlaces[] =
		[
			'name' => __('Inspecciones'),  
			'icon' => '<i class="fas fa-digital-tachograph mr-2 w-4"></i>', 
			'link' => route('fleet.dashboard.itv'), 
			'active' => request()->is('*itv*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic', 'garage']),
			'end_section' => true
		];
	
	$enlaces[] =
		[
			'name' => __('Ordenes de Reparación'),  
			'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
			'link' => route('fleet.repair-orders.index'),
			'active' => request()->is('fleet/repair-orders*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'capataz', 'garage_boss', 'garage', 'mechanic'])
		];
	$enlaces[] =
	[
		'name' => __('Incidencias'),  
		'icon' => '<i class="fas fa-exclamation-triangle mr-2 w-4"></i>', 
		'link' => route('fleet.incidents.index'), 
		'active' => request()->is('fleet/incidents*'),
		'badge' => App\Models\VehicleIncident::whereNull('closed_at')->whereHas('vehicle', function($q) {
			$q->allowForUser();
		})->count(),
		'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'capataz', 'garage_boss', 'driver', 'mechanic'])
	];

	$enlaces[] =
	[
		'name' => __('Lavados'),  
		'icon' => '<i class="fas fa-water mr-2 w-4"></i>', 
		'link' => route('fleet.washing.index'), 
		'active' => request()->is('fleet/washing*'),
		'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'vehicle_washing', 'garage_boss', 'mechanic']) || in_array(auth()->user()->username, ['victor1270', 'manuel1284'])
	];
	
	$enlaces[] =
	[
		'name' => __('Garantías'),  
		'icon' => '<i class="fas fa-shield-alt mr-2 w-4"></i>', 
		'link' => route('fleet.guarantees.index'), 
		'active' => request()->is('fleet/guarantees*'),
		'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'vehicle_washing', 'garage_boss', 'mechanic']) || in_array(auth()->user()->username, ['victor1270', 'manuel1284'])
	];

	$enlaces[] =
		[
			'name' => __('Vehículos'),  
			'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
			'link' => route('fleet.vehicles.index'),
			'active' => request()->is('fleet/vehicles*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic', 'garage'])
		];

	$enlaces[] =
		[
			'name' => __('Talleres'),  
			'icon' => '<i class="fas fa-warehouse mr-2 w-4"></i>', 
			'link' => route('fleet.garages.index'),
			'active' => request()->is('fleet/garage*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'mechanic'])
		];
	$enlaces[] =
		[
			'name' => __('Mecánicos'),  
			'icon' => '<i class="fas fa-wrench mr-2 w-4"></i>', 
			'link' => route('fleet.mechanics.index'),
			'active' => request()->is('fleet/mechanics*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'garage'])
		];
	$enlaces[] =
			[
				'name' => __('Contenedores'),
				'icon' => '<i class="fas fa-box mr-2 w-4"></i>',
				'link' => route('fleet.containers.index'),
				'active' => request()->is('fleet/containers*'),
				'disponible' => in_array(auth()->user()->job, ['fleet_manager'])
			];
	$enlaces[] =
		[
			'name' => __('Recambios'),
			'icon' => '<i class="fas fa-cogs mr-2 w-4"></i>',
			'link' => route('fleet.spare-parts.index'),
			'active' => request()->is('fleet/spare-parts*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager'])
		];
	$enlaces[] =
		[
			'name' => __('Clientes'),  
			'icon' => '<i class="fas fa-user-tag mr-2 w-4"></i>', 
			'link' => route('fleet.customers.index'),
			'active' => request()->is('fleet/customers*'),
			'end_section' => true,
			'disponible' => in_array(auth()->user()->job, ['fleet_manager', 'mechanic'])
		];
	$enlaces[] =
		[
			'name' => __('Carga de gastos'),
			'icon' => '<i class="fas fa-euro-sign mr-2 w-4"></i>',
			'link' => route('fleet.additional-vehicle-expenses.index'),
			'active' => request()->is('fleet/additional-vehicle-expenses*'),
			'disponible' => in_array(auth()->user()->job, ['fleet_manager'])
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
			'disponible' => in_array(auth()->user()->job, ['fleet_manager'])
		];
	$enlaces[] =
		[
			'name' => __('Datos generales'),  
			'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
			'link' => route('fleet.details.index'),
			'active' => false,
			'disponible' => in_array(auth()->user()->job, ['fleet_manager'])
		];

	if(in_array(Auth::user()->id, [3,920, 929,872,637, 928,955,904,1034,1033,1413,2169,1035])) {
		$enlaces[] =
				[
					'name' => __('Marcas y Modelos'),  
					'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
					'link' => route('fleet.manufacturers.index'),
					'active' => request()->is('fleet/manufacturers*'),
					'disponible' => auth()->user()->job == 'fleet_manager'
				];
		$enlaces[] =
				[
					'name' => __('Planes de mantenimiento'),  
					'icon' => '<i class="fas fa-layer-group mr-2 w-4"></i>', 
					'link' => route('fleet.maintenance-plans.index'), 
					'active' => request()->is('fleet/maintenance-plans*'),
					'disponible' => auth()->user()->job == 'fleet_manager'
				];
		$enlaces[] =
				[
					'name' => __('Tipos de vehículo'),
					'icon' => '<i class="fas fa-layer-group mr-2 w-4"></i>',
					'link' => route('fleet.vehicle-types.index'),
					'active' => request()->is('fleet/vehicle-types*'),
					'disponible' => auth()->user()->job == 'fleet_manager'
				];
	}

	foreach ($enlaces as $key => $enlace){
		if(!$enlace['disponible'] ){
			unset($enlaces[$key]);
		}
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
