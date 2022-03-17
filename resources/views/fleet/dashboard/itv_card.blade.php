<div class="bg-white overflow-hidden shadow rounded-lg">
  <div class="px-4 pt-5">
	<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
		<div class="flex justify-between">
			<div class="text-2xl font-semibold text-gray-900">
				{{ $vehicle->plate }}
				<div class="text-xs text-gray-800">
					<span class="px-2 bg-indigo-100 rounded-full">
						@if ($vehicle->assigned_customer_id)
							{{ $vehicle->customer ? $vehicle->customer->name:'' }}
						@endif
					</span>
					<p class="mt-2">{{ $vehicle->chassis }}</p>
					<p>{{ $vehicle->equipment }}</p>
				</div>
			</div>

			<img loading="lazy" class="w-20 h-20 rounded mb-2 object-cover" src="{{ optional($vehicle->getCover())->getLink() }}">
		</div>		
	</a>

	@if($vehicle->itv_date < date('Y-m-d'))
		<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-red-100 text-red-800" title="{{ $vehicle->itv_date }}">
		  Caducada {{ Carbon\Carbon::parse($vehicle->itv_date)->diffForHumans() }}
		</span>
	@else
		<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium leading-5 bg-yellow-100 text-yellow-800 mt-2" title="{{ $vehicle->itv_date }}">
			Caduca el {{ Carbon\Carbon::parse($vehicle->itv_date)->format('d M') }}, {{ Carbon\Carbon::parse($vehicle->itv_date)->diffForHumans() }}
		</span>
	@endif

	<div class="text-right text-xs text-indigo-800 pt-4 pb-2">
		@php
			$or = $vehicle->repairOrders()
						->whereNotNull('scheduled_itv_date')
						->whereNull('finished_at')
						->latest()
						->first();
		@endphp

		@if($or)
			Cita: {{Carbon\Carbon::parse($or->scheduled_itv_date)->format('d/m/Y')}}
			<a href="{{ route('fleet.repair-orders.show', $or) }}" class="mx-3">OR #{{ $or->id }}</a>
		@else
		<span class="p-1 border border-indigo-700 text-indigo-700 rounded-sm rounded-lg"><a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id, 'type' => 'pre-itv']) }}"><i class="p-1 fas fa-plus"></i>{{ __('Crear O.R.') }}</a></span>
		@endif
	</div>
  </div>
</div>