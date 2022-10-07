@include('fleet.vehicles.warranty-banner')


@component('components.tabs', [
	'items' => [
		[
			'name' => __('Datos vehículo'),
			'url' => route('fleet.vehicles.edit', $vehicle),
			'active' => isset($active_form) && $active_form,
			'available' => true
		],
		[
			'name' => __('Equipos'),
			'url' => route('fleet.vehicles.equipments.index', $vehicle),
			'active' => isset($active_equipments) && $active_equipments,
			'available' => true
		],
		[
			'name' => __('Extintores'),
			'url' => route('fleet.vehicles.estinguishers.index', $vehicle),
			'active' => isset($active_estinguishers) && $active_estinguishers,
			'available' => true
		],
		[
			'name' => __('Fotos'),
			'url' => route('fleet.vehicles.pictures.index', $vehicle),
			'active' => isset($active_pictures) && $active_pictures,
			'available' => true
		],
		[
			'name' => __('Archivos'),
			'url' => route('fleet.vehicles.files.index', $vehicle),
			'active' => isset($active_files) && $active_files,
			'available' => true
		],
		[
			'name' => __('Mantenimientos'),
			'url' => route('fleet.vehicles.counters.index', $vehicle),
			'active' => isset($active_counters) && $active_counters,
			'available' => true
		],
		[
			'name' => __('Notas'),
			'url' => route('fleet.vehicles.notes.index', $vehicle),
			'active' => isset($active_notes) && $active_notes,
			'available' => true
		],
		[
			'name' => __('Incidencias'),
			'url' => route('fleet.vehicles.incidents.index', $vehicle),
			'active' => isset($active_incidents) && $active_incidents,
			'available' => true
		],
		[
			'name' => __('Cliente asignado'),
			'url' => route('fleet.vehicles.customers.index', $vehicle),
			'active' => isset($active_customers) && $active_customers,
			'available' => Auth::user()->fleet->module_customers
		]
	]
])
@endcomponent