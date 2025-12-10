@extends('layouts.fleet')

@section('title', $container->reference .' '. $container->maker)

@section('content')

	<!-- Header fijo móvil -->
	<div class="sm:hidden fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-200 shadow-sm">
		<div class="flex items-center justify-between px-4 py-3">
			<a href="{{ route('fleet.containers.index') }}" class="flex items-center text-gray-600 -ml-1 p-1">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</a>
			<a href="{{ route('fleet.containers.edit', $container) }}" class="text-center flex-1 mx-2">
				<p class="text-sm font-semibold text-gray-900">{{ $container_checklist->checklist->name }}</p>
				<p class="text-xs text-green-600 underline">{{ $container->reference }}</p>
			</a>
			<a href="{{ route('fleet.containers.index') }}#rfid" onclick="sessionStorage.setItem('openRfidScanner', 'true')" class="p-1 -mr-1 text-green-600">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
				</svg>
			</a>
		</div>
	</div>

	<!-- Espaciador para header fijo en móvil -->
	<div class="sm:hidden h-16"></div>

	<!-- Navegación desktop -->
	<div class="hidden sm:block mb-4">
		<a href="{{ route('fleet.containers.checklists.index', $container) }}" class="text-green-700 hover:text-green-600 font-medium">
			<i class="fas fa-angle-double-left mr-1"></i>
			{{ __('Volver') }}
		</a>
	</div>

	<div class="hidden sm:block">
		@include('fleet.containers.edit_tabs', ['active_checklists' => true])
	</div>

	<!-- Card principal -->
	<div class="bg-white rounded-2xl shadow-sm sm:shadow border border-gray-100 overflow-hidden">
		<!-- Header del checklist (solo desktop) -->
		<div class="hidden sm:block px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
			<div class="flex items-center">
				<div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3
					{{ $container_checklist->checklist->id == \App\Models\Checklist::PREVENTIVE ? 'bg-green-100' : 'bg-amber-100' }}">
					@if($container_checklist->checklist->id == \App\Models\Checklist::PREVENTIVE)
						<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
					@else
						<svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
						</svg>
					@endif
				</div>
				<div>
					<h2 class="text-lg font-semibold text-gray-900">{{ $container_checklist->checklist->name }}</h2>
					<p class="text-sm text-gray-500">{{ $container->reference }} · {{ $container->maker }} {{ $container->model }}</p>
				</div>
				<div class="ml-auto text-right">
					<p class="text-xs text-gray-500">{{ __('Fecha') }}</p>
					<p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($container_checklist->date)->format('d/m/Y') }}</p>
				</div>
			</div>
		</div>

		<!-- Contenido del formulario -->
		<div class="p-4 sm:p-6 pb-24 sm:pb-6">
			{!! Form::model($container_checklist, [
				'route' => ['fleet.container-checklists.update', $container_checklist],
				'method' => 'PUT',
				'class' => 'w-full',
				'id' => 'checklist-form'
			]) !!}

			@include('fleet.containers.checklist.form')

			<!-- Botón guardar desktop -->
			<div class="hidden sm:flex justify-end mt-6 gap-3">
				<a href="{{ route('fleet.containers.index') }}" class="btn-outline-gray px-6 py-3">
					<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
					</svg>
					{{ __('Ir a contenedores') }}
				</a>
				<button type="submit" class="btn-indigo px-8 py-3">
					<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
					</svg>
					{{ __('Guardar checklist') }}
				</button>
			</div>

			{!! Form::close() !!}
		</div>
	</div>

	<!-- Navegación rápida móvil (después del formulario) -->
	<div class="sm:hidden mt-4 mb-24 px-1">
		<p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">{{ __('Acciones rápidas') }}</p>
		<div class="grid grid-cols-2 gap-3">
			<a href="{{ route('fleet.containers.index') }}#rfid" onclick="sessionStorage.setItem('openRfidScanner', 'true')" class="flex flex-col items-center justify-center p-4 bg-white border-2 border-gray-200 hover:border-green-300 hover:bg-green-50 rounded-xl transition-all">
				<div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mb-2">
					<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
					</svg>
				</div>
				<span class="text-sm font-medium text-gray-700">{{ __('Escanear otro') }}</span>
			</a>
			<a href="{{ route('fleet.containers.edit', $container) }}" class="flex flex-col items-center justify-center p-4 bg-white border-2 border-gray-200 hover:border-green-300 hover:bg-green-50 rounded-xl transition-all">
				<div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2">
					<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
					</svg>
				</div>
				<span class="text-sm font-medium text-gray-700">{{ __('Ver contenedor') }}</span>
			</a>
		</div>
	</div>

	<!-- Botón flotante guardar (móvil) -->
	<div class="sm:hidden fixed bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-200 p-4 shadow-lg">
		<button type="submit" form="checklist-form" class="w-full py-4 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-semibold rounded-xl transition-colors flex items-center justify-center text-base shadow-lg">
			<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
			</svg>
			{{ __('Guardar checklist') }}
		</button>
	</div>

@endsection

@push('head')
<style>
	/* Mejoras táctiles para móvil */
	@media (max-width: 640px) {
		.checklist-card {
			min-height: 64px;
		}
	}
</style>
@endpush

