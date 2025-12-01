
@component('components.tabs', [
	'items' => [
		[
			'name' => __('Datos contenedor'),
			'url' => route('fleet.containers.edit', $container),
			'active' => isset($active_form) && $active_form,
			'available' => true
		],
		[
			'name' => __('Fotos'),
			'url' => route('fleet.containers.pictures.index', $container),
			'active' => isset($active_pictures) && $active_pictures,
			'available' => true
		],
		[
			'name' => __('Incidencias'),
			'url' => route('fleet.containers.incidents.index', $container),
			'active' => isset($active_incidents) && $active_incidents,
			'available' => true
		],
		[
			'name' => __('Checklists'),
			'url' => route('fleet.containers.checklists.index', $container),
			'active' => isset($active_checklists) && $active_checklists,
			'available' => true
		]
	]
])
@endcomponent