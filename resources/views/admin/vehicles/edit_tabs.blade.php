@component('components.tabs', [
	'items' => [
		[
			'name' => 'Datos vehículo',
			'url' => route('admin.vehicles.edit', $vehicle),
			'active' => isset($active_form) && $active_form
		],
		[
			'name' => 'Equipos',
			'url' => route('admin.vehicles.equipments.index', $vehicle),
			'active' => isset($active_equipments) && $active_equipments
		],
		[
			'name' => 'Fotos',
			'url' => route('admin.vehicles.pictures.index', $vehicle),
			'active' => isset($active_pictures) && $active_pictures
		],
		[
			'name' => 'Archivos',
			'url' => route('admin.vehicles.files.index', $vehicle),
			'active' => isset($active_files) && $active_files
		],
		[
			'name' => 'Notas',
			'url' => route('admin.vehicles.notes.index', $vehicle),
			'active' => isset($active_notes) && $active_notes
		],
		[
			'name' => 'Talleres asignados',
			'url' => route('admin.vehicles.garages.index', $vehicle),
			'active' => isset($active_garages) && $active_garages
		],
		[
			'name' => 'Clientes asignados',
			'url' => route('admin.vehicles.customers.index', $vehicle),
			'active' => isset($active_customers) && $active_customers
		]
	]
])
@endcomponent