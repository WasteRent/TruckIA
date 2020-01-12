<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body class="bg-gray-200 text-gray-800">
	<div class="container mx-auto">
		<div class="pt-4 pb-10 flex items-center justify-between">
			<img class="w-32" src="https://truckts.com/img/logos/truckts_logo.png">
			<div class="flex items-center">
				<span class="text-sm mr-2">{{ Auth::user()->name }}</span>
				<a class="" href="{{ route('auth.logout') }}">
					<i class="fas fa-power-off"></i>
				</a>
			</div>
		</div>

		<div class="flex">
			<div class="w-1/6 mr-8">
				<div class="text-sm">
					<div class="flex items-center py-2">
						<i class="fas fa-home mr-2 w-4"></i>
						<a href="">Inicio</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/alerts*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-bell mr-2 w-4 {{ str_is('admin/alerts*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.alerts.index') }}" class="mr-1">Alertas</a>
						<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">3</div>
					</div>

					<div class="py-3"></div>

					<div class="flex items-center py-2 {{ str_is('admin/repair-orders*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-paste mr-2 w-4 {{ str_is('admin/repair-orders*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.repair-orders.index') }}">Ordenes de Reparación</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/operations*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-cogs mr-2 w-4 {{ str_is('admin/operations*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.operations.index') }}">Operaciones</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/maintenance-plans*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-layer-group mr-2 w-4 {{ str_is('admin/maintenance-plans*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.maintenance-plans.index') }}">Planes de Mantenimiento</a>
					</div>
						
					<div class="py-3"></div>

					<div class="flex items-center py-2 {{ str_is('admin/vehicles*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-bus-alt mr-2 w-4 {{ str_is('admin/vehicles*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.vehicles.index') }}">Vehículos</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/garages*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-warehouse mr-2 w-4 {{ str_is('admin/garages*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.garages.index') }}">Talleres</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/fleets*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-campground mr-2 w-4 {{ str_is('admin/fleets*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.fleets.index') }}">Flotas</a>
					</div>
					<div class="flex items-center py-2 {{ str_is('admin/users*', request()->route()->uri) ? 'text-indigo-600 font-bold':'' }}">
						<i class="fas fa-users mr-2 w-4 {{ str_is('admin/users*', request()->route()->uri) ? 'text-indigo-600':'icon' }}"></i>
						<a href="{{ route('admin.users.index') }}">Usuarios</a>
					</div>

					<div class="py-3"></div>

					<div class="py-2">
						<div class="flex items-center">
							<i class="icon fas fa-cog mr-2 w-4"></i>
							<span>Configuración</span>
						</div>
						<div class="ml-6 mt-2">
							<a href="{{ route('admin.families.index') }}">Familias</a>
						</div>
						<div class="ml-6 mt-2">
							<a href="{{ route('admin.manufacturers.index') }}">Marcas</a>
						</div>
					</div>
				</div>
			</div>

			<div class="w-5/6">
				<!-- <div class="flex">
					<div class="flex-1 text-center py-4 {{ str_is('admin/repair-orders*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.repair-orders.index') }}" class="">Ordenes de Reparación</a>
					</div>
				</div> -->
				
				@if (session('success_message'))
					<div class="my-3">
						@component('components.alert-success')
							{{ session('success_message') }}
						@endcomponent
					</div>
				@elseif(session('error_message'))
					<div class="my-3">
						@component('components.alert-error')
							{{ session('error_message') }}
						@endcomponent
					</div>
				@endif

				@if ($errors->any())
					<div class="my-3">
						@component('components.alert-error')
							<ul>
							    @foreach ($errors->all() as $error)
							        <li>&middot; {{ $error }}</li>
							    @endforeach
							</ul>
						@endcomponent
					</div>
				@endif

				@yield('progress')
				
				<div class="text-2xl font-light mb-3">
					@yield('title')
				</div>

				<main>@yield('content')</main>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>