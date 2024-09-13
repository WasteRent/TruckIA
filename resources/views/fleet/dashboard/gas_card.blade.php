<div class="bg-white overflow-hidden shadow rounded-lg">
  <div class="px-4 pt-5">
	<a href="{{ route('fleet.vehicles.show', $vehicle) }}">
		<div class="flex justify-between">
			<div class="text-2xl font-semibold text-gray-900">
				{{ $vehicle->plate }}
				<div class="text-xs text-gray-800">
					<span class="px-2 py-0.5 bg-blue-100 rounded-full">
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

	@if($vehicle->gas_revision_date < date('Y-m-d'))
		<span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-red-100 text-red-800" title="{{ $vehicle->gas_revision_date }}">
		  {{ __('Caducada') }} {{ Carbon\Carbon::parse($vehicle->gas_revision_date)->diffForHumans() }}
		</span>
	@else
		<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium leading-5 bg-yellow-100 text-yellow-800 mt-2" title="{{ $vehicle->gas_revision_date }}">
			{{ __('Caduca el') }} {{ Carbon\Carbon::parse($vehicle->gas_revision_date)->format('d M') }}, {{ Carbon\Carbon::parse($vehicle->gas_revision_date)->diffForHumans() }}
		</span>
	@endif

	<div class="text-right text-xs text-blue-800 pt-4 pb-2">
		<span class="p-1 border border-blue-700 text-blue-700 rounded-sm rounded-lg"><a href="{{ route('fleet.repair-orders.create', ['vehicle_id' => $vehicle->id]) }}"><i class="p-1 fas fa-plus"></i>{{ __('Crear O.R.') }}</a></span>
	</div>
  </div>
</div>