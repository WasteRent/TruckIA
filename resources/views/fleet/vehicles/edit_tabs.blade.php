@component('components.tabs', [
	'items' => [
		[
			'name' => 'Datos vehículo',
			'url' => route('fleet.vehicles.edit', $vehicle),
			'active' => isset($active_form) && $active_form,
			'available' => true
		],
		[
			'name' => 'Equipos',
			'url' => route('fleet.vehicles.equipments.index', $vehicle),
			'active' => isset($active_equipments) && $active_equipments,
			'available' => true
		],
		[
			'name' => 'Fotos',
			'url' => route('fleet.vehicles.pictures.index', $vehicle),
			'active' => isset($active_pictures) && $active_pictures,
			'available' => true
		],
		[
			'name' => 'Archivos',
			'url' => route('fleet.vehicles.files.index', $vehicle),
			'active' => isset($active_files) && $active_files,
			'available' => true
		],
		[
			'name' => 'Mantenimientos',
			'url' => route('fleet.vehicles.counters.index', $vehicle),
			'active' => isset($active_counters) && $active_counters,
			'available' => true
		],
		[
			'name' => 'Notas',
			'url' => route('fleet.vehicles.notes.index', $vehicle),
			'active' => isset($active_notes) && $active_notes,
			'available' => true
		],
		[
			'name' => 'Incidencias',
			'url' => route('fleet.vehicles.incidents.index', $vehicle),
			'active' => isset($active_incidents) && $active_incidents,
			'available' => true
		],
		[
			'name' => 'Cliente asignado',
			'url' => route('fleet.vehicles.customers.index', $vehicle),
			'active' => isset($active_customers) && $active_customers,
			'available' => Auth::user()->fleet->module_customers
		]
	]
])
@endcomponent