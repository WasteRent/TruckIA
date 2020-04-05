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
			'name' => 'Notas',
			'url' => route('fleet.vehicles.notes.index', $vehicle),
			'active' => isset($active_notes) && $active_notes
		],
		[
			'name' => 'Talleres asignados',
			'url' => route('fleet.vehicles.garages.index', $vehicle),
			'active' => isset($active_garages) && $active_garages
		],
		[
			'name' => 'Clientes asignado',
			'url' => route('fleet.vehicles.customers.index', $vehicle),
			'active' => isset($active_customers) && $active_customers
		]
	]
])
@endcomponent