@extends('layouts.pdf')

@section('content')
@php
	$container = $container_checklist->container;
	$total_items = $container_checklist->items->count();
	$checked_items = $container_checklist->items->where('is_checked', true)->count();
@endphp
<div class="p-4">
	<!-- Cabecera -->
	<div class="border-b border-gray-200 pb-4 mb-6">
		<div class="flex items-baseline justify-between mb-2">
			<div>
				<h1 class="text-xl font-semibold text-gray-900">{{ $container_checklist->checklist->name }}</h1>
				<p class="text-sm text-gray-600">
					{{ $container->reference }}
					@if($container->maker || $container->model)
						· {{ $container->maker }} {{ $container->model }}
					@endif
				</p>
			</div>
			<div class="text-sm text-gray-600 text-right">
				<div class="flex items-center gap-4 justify-end">
					@if($container->location)
						<span>
							<span class="font-semibold text-gray-800">{{ __('Ubicación') }}:</span>
							{{ $container->location }}
						</span>
					@endif
					<span>
						<span class="font-semibold text-gray-800">{{ __('Fecha') }}:</span>
						{{ \Carbon\Carbon::parse($container_checklist->date)->format('d/m/Y') }}
					</span>
					@if($container->createdBy)
						<span>
							<span class="font-semibold text-gray-800">{{ __('Creado por') }}:</span>
							{{ $container->createdBy->name ?: '—' }}
						</span>
					@endif
				</div>
			</div>
		</div>
	</div>
	<!-- Items por categoría -->
	@foreach ($container_checklist->items->groupBy('checklistItem.category') as $category => $items)
		<div class="mb-6">
			<div class="flex items-center mb-3">
				<div class="flex-shrink-0 w-1 h-6 bg-green-500 rounded-full mr-3"></div>
				<h3 class="text-base font-semibold text-gray-900">{{ $category }}</h3>
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
			{!! $container_checklist->observations ?: __('Ninguna') !!}
		</div>
	</div>
</div>
@endsection
