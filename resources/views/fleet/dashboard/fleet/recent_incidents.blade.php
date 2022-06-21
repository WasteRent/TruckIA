@component('components.card', ['is_table' => true])
	@slot('title')
		<div class="flex items-center">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
			</svg>
			<span>{{ __('Incidencias recientes') }}</span>
		</div>
	@endslot

	@slot('corner')
		<a class="text-xs flex items-center text-blue-700" href="{{ route('fleet.incidents.index') }}">
			<span class="mr-2">Ver más</span>
			<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
			</svg>
		</a>
	@endslot
	<ul role="list" class="divide-y divide-gray-200">
		@foreach($latest_incidents as $incident)
		  <li class="py-2 px-3">
		    <p class="text-xs text-gray-900">{!! $incident->incidence !!}</p>
            <div class="flex justify-between items-center mt-3">
      	      <span class="text-xs text-gray-500">{{ $incident->vehicle->plate }} {{ $incident->vehicle->chassis }}</span>

      	      <a class="text-xs flex items-center text-blue-700" href="{{ route('fleet.fast-orders.create', ['vehicle_id' => $incident->vehicle->id, 'incident_id' => $incident->id]) }}">
      	      	<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      	      	  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      	      	</svg>
      	      	<span class="mr-2">Crear O.R.</span>
      	      </a>
            </div>
		  </li>
		@endforeach
	</ul>
@endcomponent