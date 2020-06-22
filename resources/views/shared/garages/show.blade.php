@component('components.card')
	
	@slot('corner')
		<a href="{{ route('fleet.garages.edit', $garage) }}" class="btn-outline-gray">Ver ficha completa</a>
	@endslot

	@slot('title', 'Datos del taller')
	<div class="sm:flex">
		<div class="sm:w-1/2">
			@component('components.table')
				@slot('items', [
					'Nombre' => $garage->name,
					'Web' => $garage->web,
					'Taller Contacto' => $garage->garage_name,
					'Taller Email' => $garage->garage_email,
					'Taller Teléfono' => $garage->garage_phone,
					'Administración Contacto' => $garage->administration_name,
					'Administración Email' => $garage->administration_email,
					'Administración Teléfono' => $garage->administration_phone,
					'Gerencia Contacto' => $garage->management_name,
					'Gerencia Email' => $garage->management_email,
					'Gerencia Teléfono' => $garage->management_phone,
					'Recambios Contacto' => $garage->spare_parts_name,
					'Recambios Email' => $garage->spare_parts_email,
					'Recambios Teléfono' => $garage->spare_parts_phone,
				])
			@endcomponent

			@component('components.table')
				@slot('items', [
					'Servicio Oficial 1' => $garage->officialService1 ? $garage->officialService1->name : '',
					'Servicio Oficial 2' => $garage->officialService2 ? $garage->officialService2->name : '',
					'Servicio Oficial 3' => $garage->officialService3 ? $garage->officialService3->name : '',
					'Servicio Oficial 4' => $garage->officialService4 ? $garage->officialService4->name : '',
					'Servicio Oficial 5' => $garage->officialService5 ? $garage->officialService5->name : '',
				])
			@endcomponent

			<div class="mt-8">
				@include('shared.garages.specs')		
			</div>

		</div>
		<div class="sm:w-1/2 mt-4 sm:mt-0">
			<p class="text-sm text-gray-800 mb-4">
				{{$garage->full_address}}
			</p>
			<iframe src="https://maps.google.com/maps?q={{$garage->latitude}},{{$garage->longitude}}&hl=es&z=14&amp;output=embed" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>
@endcomponent