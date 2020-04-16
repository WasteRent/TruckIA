
<div class="flex justify-between mb-3">	
	<a class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline" href="{{ route('fleet.vehicles.show', $vehicle) }}">Volver</a>
	<a href="{{ route('fleet.vehicles.show', App\Models\Vehicle::whereNull('discharged_at')->where('id', '!=', $vehicle->id)->orderBy('plate')->get()->random(1)->first()) }}">
		<i class="fas fa-arrow-alt-circle-right fa-lg text-indigo-600"></i>
	</a>
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
			'name' => 'Contadores',
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