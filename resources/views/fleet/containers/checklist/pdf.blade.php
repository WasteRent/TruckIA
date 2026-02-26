@extends('layouts.pdf')

@section('content')
@php
	$container = $container_checklist->container;
	$total_items = $container_checklist->items->count();
	$checked_items = $container_checklist->items->where('is_checked', true)->count();
@endphp
<div class="p-4">
	<!-- Cabecera -->
	<div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
		<div class="flex items-center gap-3">
			<div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $container_checklist->checklist->id == \App\Models\Checklist::PREVENTIVE ? 'bg-green-100' : 'bg-amber-100' }}">
				@if($container_checklist->checklist->id == \App\Models\Checklist::PREVENTIVE)
					<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				@else
					<svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
				@endif
			</div>
			<div>
				<h1 class="text-xl font-semibold text-gray-900">{{ $container_checklist->checklist->name }}</h1>
				<p class="text-sm text-gray-500">{{ $container->reference }} · {{ $container->maker }} {{ $container->model }}</p>
			</div>
		</div>
		<div class="flex items-center gap-6 text-right text-sm">
			@if($container->location)
				<div>
					<p class="text-xs text-gray-500">{{ __('Ubicación') }}</p>
					<p class="font-medium text-gray-900">{{ $container->location }}</p>
				</div>
			@endif
			<div>
				<p class="text-xs text-gray-500">{{ __('Fecha') }}</p>
				<p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($container_checklist->date)->format('d/m/Y') }}</p>
			</div>
			@if($container->createdBy)
				<div>
					<p class="text-xs text-gray-500">{{ __('Creado por') }}</p>
					<p class="font-medium text-gray-900">{{ $container->createdBy->name ?: '—' }}</p>
				</div>
			@endif
		</div>
	</div>

	<!-- Progreso -->
	<div class="mb-6 bg-gray-100 rounded-xl p-4">
		<div class="flex items-center justify-between mb-2">
			<span class="text-sm font-medium text-gray-700">{{ __('Progreso') }}</span>
			<span class="text-sm font-bold text-gray-900">{{ $checked_items }}/{{ $total_items }}</span>
		</div>
		<div class="w-full bg-gray-300 rounded-full h-3 overflow-hidden">
			<div class="h-3 rounded-full {{ $checked_items == $total_items ? 'bg-green-600' : 'bg-green-400' }}" style="width: {{ $total_items > 0 ? ($checked_items / $total_items * 100) : 0 }}%"></div>
		</div>
	</div>

	<!-- Items por categoría -->
	@foreach ($container_checklist->items->groupBy('checklistItem.category') as $category => $items)
		<div class="mb-6">
			<div class="flex items-center mb-3">
				<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
				<h3 class="text-base font-semibold text-gray-900">{{ $category }}</h3>
				<span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $items->count() }} items</span>
			</div>
			<div class="space-y-2">
				@foreach ($items as $item)
					<div class="flex items-center p-4 rounded-xl border-2 {{ $item->is_checked ? 'bg-green-50 border-green-300' : 'bg-white border-gray-200' }}">
						<div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center {{ $item->is_checked ? 'bg-green-500' : 'bg-gray-200' }}">
							@if($item->is_checked)
								<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
							@endif
						</div>
						<span class="ml-4 flex-1 text-sm font-medium {{ $item->is_checked ? 'text-green-800' : 'text-gray-700' }}">{{ $item->checklistItem->description }}</span>
					</div>
				@endforeach
			</div>
		</div>
	@endforeach

	<!-- Mano de obra -->
	<div class="mb-6">
		<div class="flex items-center mb-3">
			<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
			<h3 class="text-base font-semibold text-gray-900 uppercase">{{ __('Mano de obra') }}</h3>
		</div>
		@foreach ($container_checklist->workLines->where('line_type', 'labor') as $line)
			<div class="mb-2 flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 bg-white">
				<div class="flex items-center gap-2">
					<span class="text-xs font-semibold text-gray-500 uppercase">{{ __('Descripción') }}</span>
					<span class="text-sm text-gray-900">{{ $line->description }}</span>
				</div>
				<div class="flex items-center gap-2">
					<span class="text-xs font-semibold text-gray-500 uppercase">{{ __('Horas') }}</span>
					<span class="text-sm text-gray-900">{{ $line->time_in_hours }} h</span>
				</div>
			</div>
		@endforeach
		@if($container_checklist->workLines->where('line_type', 'labor')->isEmpty())
			<p class="text-sm text-gray-500 italic">{{ __('Ninguna') }}</p>
		@endif
	</div>

	<!-- Recambios -->
	<div class="mb-6">
		<div class="flex items-center mb-3">
			<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
			<h3 class="text-base font-semibold text-gray-900 uppercase">{{ __('Recambios') }}</h3>
		</div>
		@foreach ($container_checklist->workLines->where('line_type', 'part') as $line)
			<div class="mb-2 flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 bg-white">
				<div class="flex items-center gap-2">
					<span class="text-xs font-semibold text-gray-500 uppercase">{{ __('Descripción') }}</span>
					<span class="text-sm text-gray-900">{{ $line->description }}</span>
				</div>
				<div class="flex items-center gap-2">
					<span class="text-xs font-semibold text-gray-500 uppercase">{{ __('Precio') }}</span>
					<span class="text-sm text-gray-900">{{ $line->price !== null ? number_format($line->price, 2, ',', '.') . ' €' : '—' }}</span>
				</div>
			</div>
		@endforeach
		@if($container_checklist->workLines->where('line_type', 'part')->isEmpty())
			<p class="text-sm text-gray-500 italic">{{ __('Ninguno') }}</p>
		@endif
	</div>

	<!-- Observaciones -->
	<div class="mt-6">
		<p class="text-sm font-semibold text-gray-900 mb-2">{{ __('Observaciones') }}</p>
		<div class="border-2 border-gray-200 rounded-xl p-4 bg-gray-50 text-sm text-gray-900 min-h-[80px]">
			{!! nl2br(e($container_checklist->observations ?? __('Ninguna'))) !!}
		</div>
	</div>
</div>
@endsection
