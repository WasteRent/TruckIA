{{-- Card Container --}}
<div class="bg-white shadow rounded-lg">
	{{-- Card Header --}}
	<div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
		<h3 class="text-lg font-semibold text-gray-900">{{ __('Ordenes de reparación') }}</h3>
		<a target="_blank" class="btn-outline-gray" href="{{ route('fleet.vehicles.report', $vehicle) }}">Reporte</a>
	</div>

	{{-- Search Card --}}
	<div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
		@include('fleet.vehicles.repair_orders_search')
	</div>

	{{-- Tabs --}}
	<div class="border-b border-gray-200">
		<nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
			@php
				$tabs = [
					[
						'name' => 'Todos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->except('type'), ['vehicle' => $vehicle->id])),
						'active' => !in_array(request()->query('type'), ['preventive', 'corrective', 'pre-itv', 'weekly', 'tires', 'bad_use'])
					],
					[
						'name' => 'Preventivos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'preventive')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'preventive'])),
						'active' => request()->query('type') == 'preventive'
					],
					[
						'name' => 'Correctivos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'corrective')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'corrective'])),
						'active' => request()->query('type') == 'corrective'
					],
					[
						'name' => 'Pre-ITV ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'pre-itv')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'pre-itv'])),
						'active' => request()->query('type') == 'pre-itv'
					],
					[
						'name' => 'Semanal ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'weekly')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'weekly'])),
						'active' => request()->query('type') == 'weekly'
					],
					[
						'name' => 'Neumáticos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'tires')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'tires'])),
						'active' => request()->query('type') == 'tires'
					],
					[
						'name' => 'Malos usos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('type', 'bad_use')->where('vehicle_id', $vehicle->id)->count().')',
						'url' => route('fleet.vehicles.show', array_merge(request()->all(), ['vehicle' => $vehicle->id,'type' => 'bad_use'])),
						'active' => request()->query('type') == 'bad_use'
					]
				];
			@endphp
			
			@foreach($tabs as $tab)
				<a href="{{ $tab['url'] }}" 
				   class="{{ $tab['active'] ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
					{{ $tab['name'] }}
				</a>
			@endforeach
		</nav>
	</div>

	{{-- Content --}}
	<div class="p-6">
		<div class="space-y-6">
			@forelse($repair_orders as $repairOrder)
				<div class="border py-3 px-6 rounded">
					<div class="sm:flex">
						<div class="sm:w-1/2">
							@if(!$repairOrder->operations->count())
								<a href="{{ route('fleet.repair-orders.operations.index', $repairOrder) }}">
							@else
								<a href="{{ route('fleet.repair-orders.show', $repairOrder) }}">
							@endif
						
								<span class="{{ $repairOrder->state?->color }} rounded-full px-3 py-1 text-xs font-medium">
									{{ $repairOrder->state?->name }}
								</span>

								<div class="my-3"></div>

								<span class="text-gray-600">OR</span>
								<span class="uppercase font-medium">
									#{{$repairOrder->id}} {{$repairOrder->formattedType()}}
								</span>

								{{-- Table without component --}}
								<div class="mt-3">
									<div class="grid grid-cols-2 gap-3 text-sm">
										<div>
											<span class="font-medium text-gray-700">Fecha:</span>
											<span class="text-gray-900">{{ $repairOrder->created_at->format('d/m/Y H:i:s') }}</span>
										</div>
										<div>
											<span class="font-medium text-gray-700">H. Chasis:</span>
											<span class="text-gray-900">{{ $repairOrder->work_hours_chassis }}</span>
										</div>
										<div>
											<span class="font-medium text-gray-700">H. Equipo:</span>
											<span class="text-gray-900">{{ $repairOrder->work_hours_equipment }}</span>
										</div>
										<div>
											<span class="font-medium text-gray-700">Kms:</span>
											<span class="text-gray-900">{{ $repairOrder->kms }}</span>
										</div>
									</div>
								</div>

								@if(!empty($repairOrder->internal_notes))
								<p class="text-gray-700 mt-3">
									Nota: {!!$repairOrder->internal_notes!!}
								</p>
								@endif
							</a>
						</div>
						<div class="sm:w-1/2">
							<p class="form-label">{{ __('Mantenimientos') }}</p>
							<ul class="text-gray-700">
								@foreach($repairOrder->operations->pluck('maintenance_plan_name', 'maintenance_plan_id')->unique() as $plan_id => $plan_name)
								<li>{{$plan_name}} <small>ID:{{$plan_id}} </small></li>
								@endforeach
							</ul>
							<repair-order-operations :operations="{{ $repairOrder->operations->toJson() }}"></repair-order-operations>
						</div>
					</div>
				</div>
				@if(!$loop->last)
					<div class="h-8 w-1 bg-gray-300 ml-6"></div>
				@endif
			@empty
				<div class="text-center py-8">
					<p class="text-gray-500">No se encontraron órdenes de reparación.</p>
				</div>
			@endforelse
		</div>

		{{-- Pagination --}}
		@if($repair_orders->hasPages())
			<div class="mt-6 flex items-center justify-between">
				<div class="flex-1 flex justify-between sm:hidden">
					@if ($repair_orders->onFirstPage())
						<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
							« Anterior
						</span>
					@else
						<a href="{{ $repair_orders->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
							« Anterior
						</a>
					@endif

					@if ($repair_orders->hasMorePages())
						<a href="{{ $repair_orders->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
							Siguiente »
						</a>
					@else
						<span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
							Siguiente »
						</span>
					@endif
				</div>

				<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
					<div>
						<p class="text-sm text-gray-700 leading-5">
							Mostrando
							<span class="font-medium">{{ $repair_orders->firstItem() }}</span>
							a
							<span class="font-medium">{{ $repair_orders->lastItem() }}</span>
							de
							<span class="font-medium">{{ $repair_orders->total() }}</span>
							resultados
						</p>
					</div>

					<div>
						<span class="relative z-0 inline-flex shadow-sm rounded-md">
							{{-- Previous Page Link --}}
							@if ($repair_orders->onFirstPage())
								<span aria-disabled="true" aria-label="« Anterior">
									<span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
										<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
										</svg>
									</span>
								</span>
							@else
								<a href="{{ $repair_orders->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="« Anterior">
									<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
									</svg>
								</a>
							@endif

							{{-- Pagination Elements --}}
							@foreach ($repair_orders->getUrlRange(1, $repair_orders->lastPage()) as $page => $url)
								@if ($page == $repair_orders->currentPage())
									<span aria-current="page">
										<span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-600 border border-gray-300 cursor-default leading-5">{{ $page }}</span>
									</span>
								@else
									<a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Ir a la página {{ $page }}">
										{{ $page }}
									</a>
								@endif
							@endforeach

							{{-- Next Page Link --}}
							@if ($repair_orders->hasMorePages())
								<a href="{{ $repair_orders->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Siguiente »">
									<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
									</svg>
								</a>
							@else
								<span aria-disabled="true" aria-label="Siguiente »">
									<span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
										<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
										</svg>
									</span>
								</span>
							@endif
						</span>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>