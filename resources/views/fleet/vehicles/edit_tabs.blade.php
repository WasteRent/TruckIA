
<div class="flex justify-between mb-3">	
	@if($vehicle->prev() != $vehicle)
	<a href="{{ route('fleet.vehicles.edit', $vehicle->prev()) }}">
		<i class="fas fa-arrow-alt-circle-left fa-lg text-indigo-600"></i>
	</a>
	@else
	<a href=""></a>
	@endif

	@if($vehicle->next() != $vehicle)
	<a href="{{ route('fleet.vehicles.edit', $vehicle->next()) }}">
		<i class="fas fa-arrow-alt-circle-right fa-lg text-indigo-600"></i>
	</a>
	@else
	<a href=""></a>
	@endif
</div>

@component('components.tabs', [
	'items' => [
		[
			'name' => 'Datos vehículo',
			'url' => route('fleet.vehicles.edit', $vehicle),
			'active' => isset($active_form) && $active_form
		],
		[
			'name' => 'Equipos',
			'url' => route('fleet.vehicles.equipments.index', $vehicle),
			'active' => isset($active_equipments) && $active_equipments
		],
		[
			'name' => 'Fotos',
			'url' => route('fleet.vehicles.pictures.index', $vehicle),
			'active' => isset($active_pictures) && $active_pictures
		],
		[
			'name' => 'Archivos',
			'url' => route('fleet.vehicles.files.index', $vehicle),
			'active' => isset($active_files) && $active_files
		],
		[
			'name' => 'Mantenimientos',
			'url' => route('fleet.vehicles.counters.index', $vehicle),
			'active' => isset($active_counters) && $active_counters
		],
		[
			'name' => 'Notas',
			'url' => route('fleet.vehicles.notes.index', $vehicle),
			'active' => isset($active_notes) && $active_notes
		],
		[
			'name' => 'Cliente asignado',
			'url' => route('fleet.vehicles.customers.index', $vehicle),
			'active' => isset($active_customers) && $active_customers
		]
	]
])
@endcomponent