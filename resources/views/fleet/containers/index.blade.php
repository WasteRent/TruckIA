@extends('layouts.fleet')

@section('title', __('Contenedores'))

@section('content')
	@component('components.search-card')
		@include('fleet.containers.search')
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('corner')
			<div class="flex items-center gap-4">
				<button
					type="button"
					class="text-red-600 hover:text-red-700"
					title="{{ __('Descargar memoria') }}"
					onclick="openDownloadRangePdfModal()"
				>
					<i class="fas fa-lg fa-file-pdf"></i>
				</button>
				<a class="text-green-600" href="{{ route('fleet.export.containers') }}">
					<i class="fas fa-lg fa-file-excel"></i>
				</a>
				<a href="{{ route('fleet.containers.create') }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					{{ __('Nuevo') }}
				</a>
			</div>
		@endslot
		<table>
		  <thead>
		    <tr>
		      <th>{{ __('ID') }}</th>
		      <th>{{ __('Marca') }}</th>
		      <th>{{ __('Modelo') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Estado') }}</th>
		      <th class="hidden sm:table-cell">{{ __('Ubicación') }}</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($containers as $container)
		  	<tr>
				<td>{{ $container->reference }}</td>
				<td>{{ $container->maker }}</td>
				<td>{{ $container->model }}</td>
				<td class="hidden sm:table-cell">{{ __(optional($container->state)->name) }}</td>
				<td class="hidden sm:table-cell">{{ __($container->location) }}</td>
				<td>
					<div class="flex items-center gap-2">
						<button
							type="button"
							class="p-1 text-gray-600 hover:text-green-600"
							title="{{ __('Enviar checklists por correo') }}"
							onclick="openSendRangeEmailModal('{{ route('fleet.containers.checklists.send-range-pdf', $container) }}')"
						>
							<i class="icon fas fa-envelope"></i>
						</button>
						<a href="{{ route('fleet.containers.edit', $container) }}" class="p-1 text-gray-600 hover:text-green-600" title="{{ __('Editar') }}">
							<i class="icon fas fa-edit"></i>
						</a>
						@if(in_array(auth()->user()->job, ['fleet_manager','zone_administrator','container_manager']))
							<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.containers.destroy', $container) }}">
								@csrf
								@method('DELETE')
								<button class="p-1 text-red-600 hover:text-red-700" title="{{ __('Eliminar') }}">
									<i class="icon fas fa-trash-alt"></i>
								</button>
							</form>
						@endif
					</div>
				</td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	{{ $containers->appends(request()->query())->links() }}

	<!-- Modal descargar PDF global por rango de fechas -->
	<div id="download-range-pdf-modal" class="modal" style="display: none;">
		<form id="download-range-pdf-form" method="GET" action="{{ route('fleet.containers.checklists.range-pdf') }}">
			<h3 class="text-lg font-semibold mb-4">{{ __('Descargar memoria') }}</h3>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
				<div>
					<label for="download-range-date-from" class="form-label form-required">{{ __('Fecha desde') }}</label>
					<input type="date" id="download-range-date-from" name="date_from" class="form-input w-full" required>
				</div>
				<div>
					<label for="download-range-date-to" class="form-label form-required">{{ __('Fecha hasta') }}</label>
					<input type="date" id="download-range-date-to" name="date_to" class="form-input w-full" required>
				</div>
			</div>
			<div class="mb-4">
				<label for="download-range-type" class="form-label">{{ __('Tipo de memoria') }}</label>
				<select id="download-range-type" name="type" class="form-input w-full">
					<option value="all">{{ __('Preventivos y correctivos') }}</option>
					<option value="preventive">{{ __('Solo preventivos') }}</option>
					<option value="corrective">{{ __('Solo correctivos') }}</option>
				</select>
			</div>
			<div class="flex gap-3 justify-end">
				<button type="button" class="btn-outline-gray" onclick="closeDownloadRangePdfModal()">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo">
					<i class="fas fa-file-pdf mr-2"></i>{{ __('Descargar PDF') }}
				</button>
			</div>
		</form>
	</div>

	<!-- Modal enviar checklists por rango de fechas -->
	<div id="send-range-email-modal" class="modal" style="display: none;">
		<form id="send-range-email-form" method="POST" action="">
			@csrf
			<h3 class="text-lg font-semibold mb-4">{{ __('Enviar checklists por correo') }}</h3>
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
				<div>
					<label for="send-range-date-from" class="form-label">{{ __('Fecha desde') }}</label>
					<input type="date" id="send-range-date-from" name="date_from" class="form-input w-full">
				</div>
				<div>
					<label for="send-range-date-to" class="form-label">{{ __('Fecha hasta') }}</label>
					<input type="date" id="send-range-date-to" name="date_to" class="form-input w-full">
				</div>
			</div>
			<div class="mb-4">
				<label for="send-range-email-to" class="form-label form-required">{{ __('Correo electrónico') }}</label>
				<input type="email" id="send-range-email-to" name="email" class="form-input w-full" required>
			</div>
			<div class="flex gap-3 justify-end">
				<button type="button" class="btn-outline-gray" onclick="closeSendRangeEmailModal()">{{ __('Cancelar') }}</button>
				<button type="submit" class="btn-indigo">
					<i class="fas fa-envelope mr-2"></i>{{ __('Enviar') }}
				</button>
			</div>
		</form>
	</div>

	<!-- Botón flotante RFID Scanner -->
	<button
		id="rfid-fab-button"
		onclick="openRfidScanner()"
		class="fixed bottom-6 right-6 z-40 w-16 h-16 bg-green-600 hover:bg-green-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center active:scale-95"
		title="{{ __('Escanear RFID') }}"
	>
		<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
		</svg>
	</button>

	<!-- Modal RFID Scanner (Bottom Sheet en móvil) -->
	<div id="rfid-modal" class="fixed inset-0 z-50 hidden">
		<!-- Overlay -->
		<div class="absolute inset-0 bg-black/50 transition-opacity" onclick="closeRfidScanner()"></div>

		<!-- Modal Content -->
		<div id="rfid-modal-content" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl sm:rounded-2xl sm:bottom-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:max-w-md sm:w-full transform transition-transform duration-300 translate-y-full sm:translate-y-0 sm:scale-95">

			<!-- Handle bar (solo móvil) -->
			<div class="sm:hidden flex justify-center pt-3 pb-2">
				<div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
			</div>

			<!-- Header -->
			<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
				<div class="flex items-center">
					<div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
						<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
						</svg>
					</div>
					<div>
						<h3 class="text-lg font-semibold text-gray-900">{{ __('Escáner RFID') }}</h3>
						<p class="text-sm text-gray-500">{{ __('Escanea o introduce el ID') }}</p>
					</div>
				</div>
				<button onclick="closeRfidScanner()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
					<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>

			<!-- Scanner Input -->
			<div class="px-6 py-6">
				<div class="relative">
					<input
						type="text"
						id="rfid-input"
						class="w-full h-14 text-lg text-center font-mono bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all outline-none"
						placeholder="{{ __('Esperando lectura RFID...') }}"
						autocomplete="off"
						autofocus
					>
					<div id="rfid-scanning-indicator" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
						<svg class="w-5 h-5 text-green-600 animate-spin" fill="none" viewBox="0 0 24 24">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
						</svg>
					</div>
				</div>

				<!-- Instrucciones -->
				<div id="rfid-instructions" class="mt-4 text-center">
					<div class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm">
						<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
						{{ __('Acerca el tag RFID al lector') }}
					</div>
				</div>

				<!-- Resultado -->
				<div id="rfid-result" class="mt-6 hidden">
					<!-- Contenedor encontrado -->
					<div id="rfid-found" class="hidden">
						<div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
							<div class="flex items-start">
								<div class="flex-shrink-0">
									<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
								</div>
								<div class="ml-3 flex-1">
									<h4 class="text-sm font-semibold text-green-800">{{ __('Contenedor encontrado') }}</h4>
									<div class="mt-2 space-y-1">
										<p class="text-sm text-green-700"><span class="font-medium">ID:</span> <span id="result-reference" class="font-mono"></span></p>
										<p class="text-sm text-green-700"><span class="font-medium">{{ __('Marca') }}:</span> <span id="result-maker"></span></p>
										<p class="text-sm text-green-700"><span class="font-medium">{{ __('Modelo') }}:</span> <span id="result-model"></span></p>
										<p class="text-sm text-green-700"><span class="font-medium">{{ __('Estado') }}:</span> <span id="result-state"></span></p>
									</div>
								</div>
							</div>
						</div>

						<!-- Acciones rápidas: Checklists -->
						<div class="mb-4">
							<p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('Crear Checklist') }}</p>
							<div class="grid grid-cols-2 gap-3">
								<form id="rfid-preventive-form" method="POST" action="#">
									@csrf
									<input type="hidden" name="checklist_id" id="rfid-preventive-id">
									<button type="submit" class="w-full flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 border-2 border-green-200 hover:border-green-300 rounded-xl transition-all group">
										<div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
											<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
											</svg>
										</div>
										<span class="text-sm font-medium text-green-700">{{ __('Preventivo') }}</span>
									</button>
								</form>
								<form id="rfid-corrective-form" method="POST" action="#">
									@csrf
									<input type="hidden" name="checklist_id" id="rfid-corrective-id">
									<button type="submit" class="w-full flex flex-col items-center justify-center p-4 bg-amber-50 hover:bg-amber-100 border-2 border-amber-200 hover:border-amber-300 rounded-xl transition-all group">
										<div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
											<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
											</svg>
										</div>
										<span class="text-sm font-medium text-amber-700">{{ __('Correctivo') }}</span>
									</button>
								</form>
							</div>
						</div>

						<!-- Otras acciones -->
						<div class="flex gap-2">
							<a id="rfid-edit-link" href="#" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-green-50 text-gray-700 hover:text-green-700 font-medium rounded-lg transition-colors text-sm border border-gray-200 hover:border-green-200">
								<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
								</svg>
								{{ __('Editar') }}
							</a>
							<a id="rfid-checklists-link" href="#" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-green-50 text-gray-700 hover:text-green-700 font-medium rounded-lg transition-colors text-sm border border-gray-200 hover:border-green-200">
								<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
								</svg>
								{{ __('Historial') }}
							</a>
						</div>
					</div>

					<!-- Contenedor NO encontrado -->
					<div id="rfid-not-found" class="hidden">
						<div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
							<div class="flex items-start">
								<div class="flex-shrink-0">
									<svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
									</svg>
								</div>
								<div class="ml-3">
									<h4 class="text-sm font-semibold text-amber-800">{{ __('Contenedor no encontrado') }}</h4>
									<p class="mt-1 text-sm text-amber-700">{{ __('El ID') }} <span id="result-not-found-reference" class="font-mono font-bold"></span> {{ __('no existe en el sistema') }}</p>
								</div>
							</div>
						</div>
						<a id="rfid-create-link" href="#" class="mt-4 w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
							</svg>
							{{ __('Crear nuevo contenedor') }}
						</a>
					</div>
				</div>
			</div>

			<!-- Footer con botón de nuevo escaneo -->
			<div id="rfid-footer" class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-3xl sm:rounded-b-2xl hidden">
				<button onclick="resetRfidScanner()" class="w-full py-3 text-green-600 hover:text-green-700 font-medium transition-colors flex items-center justify-center">
					<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
					</svg>
					{{ __('Escanear otro contenedor') }}
				</button>
			</div>
		</div>
	</div>
@endsection

@push('head')
<style>
	#rfid-modal.show #rfid-modal-content {
		transform: translateY(0) !important;
	}
	@media (min-width: 640px) {
		#rfid-modal.show #rfid-modal-content {
			transform: translate(-50%, -50%) scale(1) !important;
		}
	}
</style>
@endpush

@push('js')
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const rfidModal = document.getElementById('rfid-modal');
		const rfidModalContent = document.getElementById('rfid-modal-content');
		const rfidInput = document.getElementById('rfid-input');
		const rfidResult = document.getElementById('rfid-result');
		const rfidFound = document.getElementById('rfid-found');
		const rfidNotFound = document.getElementById('rfid-not-found');
		const rfidInstructions = document.getElementById('rfid-instructions');
		const rfidFooter = document.getElementById('rfid-footer');
		const rfidScanningIndicator = document.getElementById('rfid-scanning-indicator');

		let searchTimeout = null;

		// Verificar si debe abrir el escáner automáticamente (viene de "Escanear otro")
		if (sessionStorage.getItem('openRfidScanner') === 'true') {
			sessionStorage.removeItem('openRfidScanner');
			setTimeout(() => {
				window.openRfidScanner();
			}, 300);
		}

		window.openRfidScanner = function() {
			rfidModal.classList.remove('hidden');
			setTimeout(() => {
				rfidModal.classList.add('show');
				rfidInput.focus();
			}, 10);
			document.body.style.overflow = 'hidden';
		}

		window.closeRfidScanner = function() {
			rfidModal.classList.remove('show');
			setTimeout(() => {
				rfidModal.classList.add('hidden');
				window.resetRfidScanner();
			}, 300);
			document.body.style.overflow = '';
		}

		window.resetRfidScanner = function() {
			rfidInput.value = '';
			rfidResult.classList.add('hidden');
			rfidFound.classList.add('hidden');
			rfidNotFound.classList.add('hidden');
			rfidInstructions.classList.remove('hidden');
			rfidFooter.classList.add('hidden');
			rfidInput.focus();
		}

		function searchContainer(reference) {
			if (!reference || reference.trim().length < 2) return;

			rfidScanningIndicator.classList.remove('hidden');
			rfidInstructions.classList.add('hidden');

			fetch('{{ route("fleet.containers.find-by-reference") }}', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}',
					'Accept': 'application/json',
				},
				body: JSON.stringify({ reference: reference.trim() })
			})
			.then(response => response.json())
			.then(data => {
				rfidScanningIndicator.classList.add('hidden');
				rfidResult.classList.remove('hidden');
				rfidFooter.classList.remove('hidden');

				if (data.found) {
					rfidFound.classList.remove('hidden');
					rfidNotFound.classList.add('hidden');

					document.getElementById('result-reference').textContent = data.container.reference || '-';
					document.getElementById('result-maker').textContent = data.container.maker || '-';
					document.getElementById('result-model').textContent = data.container.model || '-';
					document.getElementById('result-state').textContent = data.container.state || '-';
					document.getElementById('rfid-edit-link').href = data.container.edit_url;
					document.getElementById('rfid-checklists-link').href = data.container.checklists_url;

					// Configurar formularios de checklist
					const quickChecklistUrl = '{{ url("fleet/containers") }}/' + data.container.id + '/quick-checklist';

					if (data.container.preventive_checklist) {
						document.getElementById('rfid-preventive-form').action = quickChecklistUrl;
						document.getElementById('rfid-preventive-id').value = data.container.preventive_checklist.id;
					}

					if (data.container.corrective_checklist) {
						document.getElementById('rfid-corrective-form').action = quickChecklistUrl;
						document.getElementById('rfid-corrective-id').value = data.container.corrective_checklist.id;
					}
				} else {
					rfidFound.classList.add('hidden');
					rfidNotFound.classList.remove('hidden');

					document.getElementById('result-not-found-reference').textContent = data.reference;
					document.getElementById('rfid-create-link').href = data.create_url;
				}
			})
			.catch(error => {
				rfidScanningIndicator.classList.add('hidden');
				console.error('Error:', error);
				alert('{{ __("Error al buscar el contenedor") }}');
			});
		}

		// Detectar cuando el lector RFID escribe en el input
		rfidInput.addEventListener('input', function(e) {
			clearTimeout(searchTimeout);

			const value = e.target.value;
			if (value.length >= 2) {
				// Los lectores RFID suelen escribir rápido y añadir un Enter al final
				// Esperamos 500ms después de la última entrada para buscar
				searchTimeout = setTimeout(() => {
					searchContainer(value);
				}, 500);
			}
		});

		// También detectar Enter para búsqueda manual
		rfidInput.addEventListener('keypress', function(e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				clearTimeout(searchTimeout);
				searchContainer(this.value);
			}
		});

		// Cerrar con Escape
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && !rfidModal.classList.contains('hidden')) {
				window.closeRfidScanner();
			}
		});
	});

	function openSendRangeEmailModal(url) {
		document.getElementById('send-range-email-form').action = url;
		document.getElementById('send-range-email-to').value = '';
		document.getElementById('send-range-date-from').value = '';
		document.getElementById('send-range-date-to').value = '';
		$('#send-range-email-modal').modal();
	}

	function closeSendRangeEmailModal() {
		$('#send-range-email-modal').modal('close');
	}

	function openDownloadRangePdfModal() {
		document.getElementById('download-range-date-from').value = '';
		document.getElementById('download-range-date-to').value = '';
		$('#download-range-pdf-modal').modal();
	}

	function closeDownloadRangePdfModal() {
		$('#download-range-pdf-modal').modal('close');
	}
</script>
@endpush
