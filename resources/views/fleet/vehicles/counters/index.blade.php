@extends('layouts.fleet')

@section('title', $vehicle->plate . ' ' . $vehicle->chassis)

@section('content')

	@include('fleet.vehicles.edit_tabs', ['active_counters' => true])

	@component('components.card')
	  @slot('title', 'Contadores')

	  @if(in_array(auth()->user()->job, ['fleet_manager', 'garage_boss', 'mechanic']))
		@slot('corner')
			<div class="flex">

				<import-vehicle-counters class="mr-3"
					:plans="{{ json_encode($vehicle->getMaintenancePlans()) }}"
					:vehicle-id="{{$vehicle->id}}"
					:current-counters="{{ json_encode($vehicle->counters) }}">
				</import-vehicle-counters>

				@if(in_array(auth()->user()->job, ['fleet_manager', 'mechanic']))
				<button onclick="openInitialStateModal()" class="btn-outline-blue flex items-center mr-3">
					<i class="icon fas fa-cog mr-2"></i>
					Estado Inicial
				</button>
				<a href="{{ route('fleet.vehicles.counters.create', $vehicle) }}" class="btn-outline-gray flex items-center">
					<i class="icon fas fa-plus-circle mr-2"></i>
					Añade un plan a medida
				</a>
				@endif
			</div>
		@endslot
	  @endif
	  @include('fleet.vehicles.counters.update-form')

	  <fieldset>
	  	<legend>Cambios</legend>
	  	@foreach($vehicle->counterHistory as $history)
	  		<div class="flex my-1 px-2 py-1 rounded text-xs">
	  			<div class="w-1/2">
	  				<span class="">
	  					Kms: {{ $history->kms }}, Chasis: {{ $history->work_hours_chassis }}, @if($vehicle->vehicle_type_id != 16) <!-- barredora --> Equipo: {{ $history->work_hours_equipment }} @endif
	  				</span>
	  			</div>
	  			<div class="w-1/2">
	  				{{ $history->user?->name }} &middot;
	  				{{$history->created_at->format('d/m/y H:i:s')}}
	  			</div>
	  		</div>
	  	@endforeach
	  </fieldset>

	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Chasis')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'chassis')->sortBy('description') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }} <small>ID:{{$counter->plan_id}}</small>
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(auth()->user()->job, ['fleet_manager', 'mechanic']))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

	@component('components.card', ['is_table' => true])
		@slot('title', 'Mantenimientos Equipo')
		<table>
		  <thead>
		    <tr>
		      <th>Descripción</th>
		      <th>Actual</th>
		      <th>Máximo</th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  	@foreach($vehicle->counters->where('vehicle_category', 'equipment') as $counter)
		  	<tr>
		  	  <td>
		  	  	{{ $counter->description }} <small>ID:{{$counter->plan_id}}</small>
		  	  </td>
		  	  <td>{{ round($counter->current, 2) }} ({{ $counter->completedPercent  }}%)</td>
		  	  <td>
		  	  	<strong>{{ $counter->max }}</strong>
		  	  	@if($counter->type == 'work_hours')
		  	  		H. Trabajo
		  	  	@elseif($counter->type == 'natural_hours')
		  	  		H. Naturales
		  	  	@elseif($counter->type == 'kms')
		  	  		Kms
		  	  	@endif
		  	  </td>
		  	  <td>
		  	  	@if(in_array(auth()->user()->job, ['fleet_manager', 'mechanic']))
		  	  	<div class="flex">
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.reset', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			<button class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline mr-3">Reiniciar</button>
		  	  		</form>

		  	  		<a href="{{ route('fleet.vehicles.counters.edit', [$vehicle, $counter]) }}" class="mr-3">
		  	  			<i class="icon fas fa-edit"></i>
		  	  		</a>
		  	  		<form method="POST" onsubmit="return confirmDelete()" action="{{ route('fleet.vehicles.counters.destroy', [$vehicle, $counter]) }}">
		  	  			@csrf
		  	  			@method('DELETE')
		  	  			<button><i class="icon fas fa-trash-alt"></i></button>
		  	  		</form>
		  	  	</div>
		  	  	@endif
		  	  </td>
		  	</tr>
		  	@endforeach
		  </tbody>
		</table>
	@endcomponent

			<!-- Modal para configurar estado inicial -->
	<div id="initialStateModal" class="fixed inset-0 z-[99999] hidden" style="z-index: 99999 !important;">
		<!-- Backdrop -->
		<div class="fixed inset-0 bg-gray-500 bg-opacity-30 transition-opacity backdrop-blur-sm"></div>

		<!-- Modal container -->
		<div class="fixed inset-0 z-[99999] flex items-center justify-center p-4 overflow-y-auto" style="z-index: 99999 !important;">
			<div class="relative w-full max-w-3xl mx-auto my-auto">
				<div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all" style="z-index: 99999 !important;">

					<!-- Header -->
					<div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
						<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
							Configurar Estado Inicial de Mantenimientos
						</h3>
						<div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-md">
							<div class="flex">
								<div class="flex-shrink-0">
									<i class="icon fas fa-info-circle text-blue-400"></i>
								</div>
								<div class="ml-3">
									<p class="text-sm text-blue-700">
										<strong>Instrucciones:</strong> Introduce el valor que tenía cada contador cuando se realizó por última vez el mantenimiento.
										Esto establecerá el punto de partida correcto para el próximo mantenimiento programado.
									</p>
								</div>
							</div>
						</div>

						<form id="initialStateForm" method="POST" action="{{ route('fleet.vehicles.initial-maintenance-state.store', $vehicle) }}">
							@csrf

							@if($vehicle->counters->where('vehicle_category', 'chassis')->count() > 0)
							<div class="mb-6">
								<h4 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Mantenimientos Chasis</h4>
								<div class="space-y-3">
									@foreach($vehicle->counters->where('vehicle_category', 'chassis')->sortBy('description') as $counter)
									<div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
										<div class="flex-1">
											<label class="text-sm font-medium text-gray-800">
												{{ $counter->description }}
												<span class="text-xs text-gray-500 ml-1">(Plan ID: {{$counter->plan_id}})</span>
											</label>
											<div class="text-xs text-gray-600 mt-1 flex items-center gap-4">
												<span class="inline-flex items-center">
													<i class="fas fa-tag mr-1 text-gray-400"></i>
													Tipo:
													@if($counter->type == 'work_hours')
														Horas de Trabajo
													@elseif($counter->type == 'natural_hours')
														Horas Naturales
													@elseif($counter->type == 'kms')
														Kilómetros
													@endif
												</span>
												<span class="inline-flex items-center">
													<i class="fas fa-chart-line mr-1 text-gray-400"></i>
													Máximo: {{ $counter->max }}
												</span>
											</div>
										</div>
										<div class="ml-6 text-right">
											<label class="block text-xs font-medium text-gray-600 mb-1">
												Valor cuando se hizo por última vez
											</label>
											<input
												type="number"
												name="counters[{{ $counter->id }}]"
												step="0.01"
												min="0"
												class="w-28 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
												placeholder="0.00"
											>
										</div>
									</div>
									@endforeach
								</div>
							</div>
							@endif

							@if($vehicle->counters->where('vehicle_category', 'equipment')->count() > 0)
							<div class="mb-6">
								<h4 class="text-md font-medium text-gray-800 mb-3 border-b pb-2">Mantenimientos Equipo</h4>
								<div class="space-y-3">
									@foreach($vehicle->counters->where('vehicle_category', 'equipment')->sortBy('description') as $counter)
									<div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
										<div class="flex-1">
											<label class="text-sm font-medium text-gray-800">
												{{ $counter->description }}
												<span class="text-xs text-gray-500 ml-1">(Plan ID: {{$counter->plan_id}})</span>
											</label>
											<div class="text-xs text-gray-600 mt-1 flex items-center gap-4">
												<span class="inline-flex items-center">
													<i class="fas fa-tag mr-1 text-gray-400"></i>
													Tipo:
													@if($counter->type == 'work_hours')
														Horas de Trabajo
													@elseif($counter->type == 'natural_hours')
														Horas Naturales
													@elseif($counter->type == 'kms')
														Kilómetros
													@endif
												</span>
												<span class="inline-flex items-center">
													<i class="fas fa-chart-line mr-1 text-gray-400"></i>
													Máximo: {{ $counter->max }}
												</span>
											</div>
										</div>
										<div class="ml-6 text-right">
											<label class="block text-xs font-medium text-gray-600 mb-1">
												Valor cuando se hizo por última vez
											</label>
											<input
												type="number"
												name="counters[{{ $counter->id }}]"
												step="0.01"
												min="0"
												max="{{ $counter->max }}"
												class="w-28 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
												placeholder="0.00"
											>
										</div>
									</div>
									@endforeach
								</div>
							</div>
							@endif

							<!-- Footer -->
							<div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 border-t border-gray-200">
								<button type="button" onclick="closeInitialStateModal()"
										class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
									<i class="fas fa-times mr-2"></i>
									Cancelar
								</button>
								<button type="submit"
										class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
									<i class="fas fa-save mr-2"></i>
									Guardar Estado Inicial
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function openInitialStateModal() {
			const modal = document.getElementById('initialStateModal');
			modal.classList.remove('hidden');
		}

		function closeInitialStateModal() {
			const modal = document.getElementById('initialStateModal');
			modal.classList.add('hidden');
		}

		// Cerrar modal al hacer clic en el backdrop
		document.addEventListener('click', function(e) {
			if (e.target.classList.contains('bg-gray-500') && e.target.classList.contains('bg-opacity-30')) {
				closeInitialStateModal();
			}
		});

		// Cerrar modal con ESC
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				closeInitialStateModal();
			}
		});
	</script>

@endsection