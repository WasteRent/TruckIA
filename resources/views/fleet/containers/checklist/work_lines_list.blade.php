<div class="mt-6 mb-6">
	<!-- Mano de obra -->
	<div class="mb-6">
		<div class="flex items-center mb-3">
			<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
			<h3 class="text-base font-semibold text-gray-900 uppercase">{{ __('Mano de obra') }}</h3>
			<button type="button"
				class="ml-auto w-9 h-9 rounded-full bg-green-600 text-white flex items-center justify-center shadow hover:bg-green-700 active:scale-95 transition flex-shrink-0"
				onclick="openLaborLineModal()"
				aria-label="{{ __('Añadir mano de obra') }}">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
				</svg>
			</button>
		</div>
		@foreach ($container_checklist->workLines->where('line_type', 'labor') as $line)
			<div class="mb-2">
				<div class="bg-white border-2 border-gray-200 rounded-xl px-4 py-3">
					<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
						<div class="min-w-0 flex-1">
							<div class="flex items-center gap-2 flex-wrap">
								<span class="text-xs font-semibold text-gray-500 uppercase tracking-wide flex-shrink-0">{{ __('Descripción') }}</span>
								<span class="text-sm text-gray-900 break-words">{{ $line->description }}</span>
							</div>
						</div>
						<div class="flex items-center justify-between gap-2 flex-shrink-0 pt-3 border-t border-gray-100 sm:border-0 sm:pt-0">
							<div class="flex items-center gap-2">
								<span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Horas') }}</span>
								<span class="text-sm text-gray-900">{{ $line->time_in_hours }} h</span>
							</div>
							<div class="flex items-center gap-1">
								<button type="button" class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded touch-manipulation" aria-label="{{ __('Editar') }}"
									onclick="openEditLaborLineModal({{ $line->id }}, {{ json_encode($line->description) }}, {{ json_encode($line->time_in_hours) }})">
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
								</button>
								<form method="POST" action="{{ route('fleet.container-checklists.work-lines.destroy', [$container_checklist, $line]) }}" class="inline" onsubmit="return confirm('{{ __('¿Eliminar esta línea?') }}')">
									@csrf
									@method('DELETE')
									<button type="submit" class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded touch-manipulation" aria-label="{{ __('Eliminar') }}">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	<!-- Recambios -->
	<div>
		<div class="flex items-center mb-3">
			<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
			<h3 class="text-base font-semibold text-gray-900 uppercase">{{ __('Recambios') }}</h3>
			<button type="button"
				class="ml-auto w-9 h-9 rounded-full bg-green-600 text-white flex items-center justify-center shadow hover:bg-green-700 active:scale-95 transition flex-shrink-0"
				onclick="openPartLineModal()"
				aria-label="{{ __('Añadir recambio') }}">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
				</svg>
			</button>
		</div>
		@foreach ($container_checklist->workLines->where('line_type', 'part') as $line)
			<div class="mb-2">
				<div class="bg-white border-2 border-gray-200 rounded-xl px-4 py-3">
					<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
						<div class="min-w-0 flex-1">
							<div class="flex items-center gap-2 flex-wrap">
								<span class="text-xs font-semibold text-gray-500 uppercase tracking-wide flex-shrink-0">{{ __('Descripción') }}</span>
								<span class="text-sm text-gray-900 break-words">{{ $line->description }}</span>
							</div>
						</div>
						<div class="flex items-center justify-between gap-2 flex-shrink-0 pt-3 border-t border-gray-100 sm:border-0 sm:pt-0">
							<div class="flex items-center gap-2">
								<span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ __('Precio') }}</span>
								<span class="text-sm text-gray-900">
									@if($line->price !== null)
										{{ number_format($line->price, 2, ',', '.') }} €
									@else
										—
									@endif
								</span>
							</div>
							<div class="flex items-center gap-1">
								<button type="button" class="p-2 text-gray-600 hover:text-gray-700 hover:bg-gray-100 rounded touch-manipulation" aria-label="{{ __('Editar') }}"
									onclick="openEditPartLineModal({{ $line->id }}, {{ json_encode($line->description) }}, {{ $line->price !== null ? json_encode((string)$line->price) : 'null' }})">
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
								</button>
								<form method="POST" action="{{ route('fleet.container-checklists.work-lines.destroy', [$container_checklist, $line]) }}" class="inline" onsubmit="return confirm('{{ __('¿Eliminar esta línea?') }}')">
									@csrf
									@method('DELETE')
									<button type="submit" class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded touch-manipulation" aria-label="{{ __('Eliminar') }}">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
