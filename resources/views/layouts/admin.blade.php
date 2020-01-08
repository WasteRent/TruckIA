<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>
<body class="bg-gray-200 text-gray-800">

	<div class="container mx-auto">
		<div class="pt-4 pb-10 flex items-center justify-between">
			<div class="flex items-center">
				<div class="mr-6">
					<img class="w-32" src="https://truckts.com/img/logos/truckts_logo.png">
				</div>
				<h1 class="py-6 text-2xl mt-2">Gestión de Mantenimientos - Admin</h1>
			</div>
			<div>
				<a href="{{ route('auth.logout') }}"><ion-icon class="text-xl" name="power"></ion-icon></a>
			</div>
		</div>

		<div class="flex">
			<div class="w-1/6 mr-8">
				<div class="leading-loose">
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="logo-model-s"></ion-icon>
						Vehículo Existente
					</div>
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="add-circle"></ion-icon>
						Vehículo Nuevo
					</div>
					<div class="flex items-center py-1">
						<ion-icon class="mr-2" name="clipboard"></ion-icon>
						Planes de Mantenimiento
					</div>
				</div>
			</div>

			<div class="w-5/6">
				<div class="flex">
					<div class="flex-1 text-center py-4 {{ str_is('admin/repair-orders*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.repair-orders.index') }}" class="">Ordenes de Reparación</a>
					</div>
					<div class="flex-1 text-center py-4 {{ str_is('admin/operations*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.operations.index') }}">Operaciones</a>
					</div>
					<div class="flex-1 text-center py-4 {{ str_is('admin/vehicles*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.vehicles.index') }}">Vehículos</a>
					</div>
					<div class="flex-1 text-center py-4 {{ str_is('admin/garages*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.garages.index') }}">Talleres</a>
					</div>
					<div class="flex-1 text-center py-4 {{ str_is('admin/alerts*', request()->route()->uri) ? 'tab-active':'tab-inactive' }}">
						<a href="{{ route('admin.alerts.index') }}">Alertas</a>
					</div>
				</div>
				
				<div class="my-3">
					@if (session('success_message'))
						@component('components.alert-success')
							{{ session('success_message') }}
						@endcomponent
					@elseif(session('error_message'))
						@component('components.alert-error')
							{{ session('error_message') }}
						@endcomponent
					@endif

					@if ($errors->any())
						@component('components.alert-error')
							<ul>
							    @foreach ($errors->all() as $error)
							        <li>&middot; {{ $error }}</li>
							    @endforeach
							</ul>
						@endcomponent
					@endif
				</div>

				<div>
					@yield('content')	
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>