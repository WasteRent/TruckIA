@component('components.card')
	@slot('title', __('Ordenes de reparación'))

	@slot('corner')
		<a target="_blank" class="btn-outline-gray" href="{{ route('fleet.vehicles.report', $vehicle) }}">Reporte</a>
	@endslot
	
	@component('components.search-card')
		@include('fleet.vehicles.repair_orders_search')
	@endcomponent

	
	
	@component('components.tabs', [
		'items' => [
			[
				'name' => 'Todos ('.App\Models\RepairOrder::filter(request()->except('type'))->where('vehicle_id', $vehicle->id)->count().')',
				'url' => route('fleet.vehicles.show', $vehicle->id, request()->except('type')),
				'active' => !in_array(request()->query('type'), ['preventive', 'corrective', 'pre-itv'])
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
		]
	])
	@endcomponent            
    
    <display-more>
    	<template v-slot:head>
    		@foreach($repair_orders->where('vehicle_id', $vehicle->id)->take(3) as $repairOrder)
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

    							@component('components.table')
    								@slot('items', [
    									'Fecha' => $repairOrder->created_at->format('d/m/Y H:i:s'),
    									'H. Chasis' => $repairOrder->work_hours_chassis,
    									'H. Equipo' => $repairOrder->work_hours_equipment,
    									'Kms' => $repairOrder->kms
    								])
    							@endcomponent

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
    							@foreach($repairOrder->operations->pluck('maintenance_plan_name')->unique() as $plan)
    							<li>{{$plan}}</li>
    							@endforeach
    						</ul>
    						<repair-order-operations :operations="{{ $repairOrder->operations->toJson() }}"></repair-order-operations>
    					</div>
    				</div>
    			</div>
    			@if(!$loop->last)
    				<div class="h-8 w-1 bg-gray-300 ml-6"></div>
    			@endif
    		@endforeach
    	</template>
    	<template v-slot:body>
    		@foreach($repair_orders->where('vehicle_id', $vehicle->id)->skip(3) as $repairOrder)
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

    							@component('components.table')
    								@slot('items', [
    									'Fecha' => $repairOrder->created_at->format('d/m/Y H:i:s'),
    									'H. Chasis' => $repairOrder->work_hours_chassis,
    									'H. Equipo' => $repairOrder->work_hours_equipment,
    									'Kms' => $repairOrder->kms
    								])
    							@endcomponent

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
    							@foreach($repairOrder->operations->pluck('maintenance_plan_name')->unique() as $plan)
    							<li>{{$plan}}</li>
    							@endforeach
    						</ul>
    						<repair-order-operations :operations="{{ $repairOrder->operations->toJson() }}"></repair-order-operations>
    					</div>
    				</div>
    			</div>
    			@if(!$loop->last)
    				<div class="h-8 w-1 bg-gray-300 ml-6"></div>
    			@endif
    		@endforeach
    	</template>
    </display-more>

	

@endcomponent