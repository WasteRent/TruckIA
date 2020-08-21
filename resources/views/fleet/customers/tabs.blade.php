@component('components.tabs', [
	'items' => [
		[
			'name' => 'Editar datos del cliente',
			'url' => route('fleet.customers.edit', $customer),
			'active' => isset($active_edit) && $active_edit
		],
		[
			'name' => 'Talleres asignados',
			'url' => route('fleet.customers.garages.index', $customer),
			'active' => isset($active_garages) && $active_garages
		],
		[
			'name' => 'Vehículos',
			'url' => route('fleet.customers.vehicles.index', $customer),
			'active' => isset($active_vehicles) && $active_vehicles
		],
		[
			'name' => 'Usuarios',
			'url' => route('fleet.customers.users.index', $customer),
			'active' => isset($active_users) && $active_users
		]
	]
])
@endcomponent