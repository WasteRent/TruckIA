@component('components.tabs', [
	'items' => [
		[
			'name' => 'Editar datos del taller',
			'url' => route('fleet.garages.edit', $garage),
			'active' => isset($active_edit) && $active_edit
		],
		[
			'name' => 'Especialidades',
			'url' => route('fleet.garage.specialities.index', $garage),
			'active' => isset($active_specs) && $active_specs
		],
		[
			'name' => 'Usuarios',
			'url' => route('fleet.garage.users.index', $garage),
			'active' => isset($active_users) && $active_users
		]
	]
])
@endcomponent