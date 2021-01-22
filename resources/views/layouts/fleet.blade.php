@extends('layouts.master')

@section('app')
	@include('shared.alerts')

	@section('nav-items')
	{{
		json_encode([
			[
				'name' => 'Preventivos',  
				'icon' => '<i class="fas fa-tachometer-alt mr-2 w-4"></i>', 
				'link' => route('fleet.dashboard.preventives'), 
				'active' => request()->is('*preventives*')
			],
			[
				'name' => 'ITV',  
				'icon' => '<i class="fas fa-digital-tachograph mr-2 w-4"></i>', 
				'link' => route('fleet.dashboard.itv'), 
				'active' => request()->is('*itv*')
			],
			[
				'name' => 'Alertas',  
				'icon' => '<i class="fas fa-bell mr-2 w-4"></i>', 
				'link' => route('fleet.alerts.index'), 
				'active' => request()->is('fleet/alerts*'),
				'badge' => Auth::user()->fleet->alerts()->pending()->count()
			],
			[
				'name' => 'Ordenes de Reparación',  
				'icon' => '<i class="fas fa-paste mr-2 w-4"></i>', 
				'link' => route('fleet.repair-orders.index', ['state_id' => 1]),
				'active' => request()->is('fleet/repair-orders*'),
				'end_section' => true
			],
			[
				'name' => 'Vehículos',  
				'icon' => '<i class="fas fa-bus-alt mr-2 w-4"></i>', 
				'link' => route('fleet.vehicles.index'),
				'active' => request()->is('fleet/vehicles*')
			],
			[
				'name' => 'Talleres',  
				'icon' => '<i class="fas fa-warehouse mr-2 w-4"></i>', 
				'link' => route('fleet.garages.index'),
				'active' => request()->is('fleet/garage*')
			],
			[
				'name' => 'Clientes',  
				'icon' => '<i class="fas fa-user-tag mr-2 w-4"></i>', 
				'link' => route('fleet.customers.index'),
				'active' => request()->is('fleet/customers*'),
				'end_section' => true
			],
			[
				'name' => 'Usuarios',  
				'icon' => '<i class="fas fa-users mr-2 w-4"></i>', 
				'link' => route('fleet.users.index'),
				'active' => request()->is('fleet/users*'),
				'end_section' => true
			],
			[
				'name' => 'Grupos empresariales',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('fleet.enterprise-groups.index'),
				'active' => false
			],
			[
				'name' => 'Datos generales',  
				'icon' => '<i class="fas fa-cog mr-2 w-4"></i>', 
				'link' => route('fleet.details.index'),
				'active' => false
			]
		])
	}}
	@endsection

	@yield('progress')

	<main>
		@yield('content')
		
		<br><br><br>
	</main>
@endsection
