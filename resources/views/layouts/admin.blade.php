@extends('layouts.master')

@section('app')
<div class="pt-4 pb-10 flex items-center justify-between">
	<img class="w-32" src="{{ asset('img/truckts_logo.png') }}">
	<div class="flex items-center">
		<a href="#" class="flex-shrink-0 group block focus:outline-none mr-8">
		  <div class="flex items-center">
		    <div>
		      <img class="inline-block h-9 w-9 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
		    </div>
		    <div class="ml-3">
		      <p class="text-sm leading-5 font-medium text-gray-700 group-hover:text-gray-900">
		        {{ Auth::user()->name }}
		      </p>
		      <p class="text-xs leading-4 font-medium text-gray-500 group-hover:text-gray-700 group-focus:underline transition ease-in-out duration-150">
		        Perfil
		      </p>
		    </div>
		  </div>
		</a>
		<form method="POST" action="{{ route('logout') }}">
			@csrf
			<button><i class="fas fa-power-off"></i></button>
		</form>
	</div>
</div>
<div class="flex">
	<div class="w-1/6 mr-8">
		<div class="text-sm">
			<div class="flex items-center py-2 {{ request()->is('admin') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-home mr-2 w-4 {{ request()->is('admin') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.home') }}">Inicio</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/alerts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bell mr-2 w-4 {{ request()->is('admin/alerts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.alerts.index') }}" class="mr-1">Alertas</a>
				@if(Auth::user()->alerts()->count())
					<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">
						{{Auth::user()->alerts()->count()}}
					</div>
				@endif
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/feedbacks*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-comment-dots mr-2 w-4 {{ request()->is('admin/feedbacks*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.feedbacks.index') }}" class="mr-1">Feedback</a>
				@if(App\Models\Feedback::where('reviewed', 0)->count() > 0)
				<div style="font-size: 0.6rem" class="px-1 bg-red-600 text-white rounded-full">
					{{ App\Models\Feedback::where('reviewed', 0)->count() }}
				</div>
				@endif
			</div>

			<div class="py-3"></div>

			<div class="flex items-center py-2 {{ request()->is('admin/repair-orders*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-paste mr-2 w-4 {{ request()->is('admin/repair-orders*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.repair-orders.index') }}">Ordenes de Reparación</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/maintenance-plans*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-layer-group mr-2 w-4 {{ request()->is('admin/maintenance-plans*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.maintenance-plans.index') }}">Planes de Mantenimiento</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/operations*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-cogs mr-2 w-4 {{ request()->is('admin/operations*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.operations.index') }}">Operaciones</a>
			</div>
			
				
			<div class="py-3"></div>
			
			<div class="flex items-center py-2 {{ request()->is('admin/garage*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-warehouse mr-2 w-4 {{ request()->is('admin/garage*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.garages.index') }}">Talleres</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/customers*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-user-tag mr-2 w-4 {{ request()->is('admin/customers*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.customers.index') }}">Clientes</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/vehicles*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-bus-alt mr-2 w-4 {{ request()->is('admin/vehicles*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.vehicles.index') }}">Vehículos</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/fleets*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-campground mr-2 w-4 {{ request()->is('admin/fleets*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.fleets.index') }}">Flotas</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/spare-parts*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-wrench mr-2 w-4 {{ request()->is('admin/spare-parts*') ? 'text-indigo-600':'icon' }}"></i>
				<a href="{{ route('admin.spare-parts.index') }}">Recambios</a>
			</div>
			<div class="flex items-center py-2 {{ request()->is('admin/users*') ? 'text-indigo-600 font-bold':'' }}">
				<i class="fas fa-users mr-2 w-4 {{ request()->is('admin/users*') ? 'text-indigo-600':'icon' }}"></i>
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
				<div class="ml-6 mt-2">
					<a href="{{ route('admin.enterprise-groups.index') }}">Empresas</a>
				</div>
			</div>
		</div>
	</div>

	<div class="w-full">
		@include('shared.alerts')

		@yield('progress')
		
		<div class="text-2xl font-light mb-3">
			@yield('title')
		</div>

		<main id="app">@yield('content')</main>
		<br><br>
	</div>
</div>
@endsection
