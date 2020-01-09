@component('components.card')
	@slot('title', 'Datos del taller')
	<div class="flex">
		<div class="w-1/2">
			@component('components.table')
				@slot('items', [
					'Nombre' => $garage->name,
					'Email' => $garage->email,
					'Teléfono' => $garage->phone
				])
			@endcomponent
		</div>
		<div class="w-1/2">
			<p class="text-sm text-gray-800 mb-4">
				{{$garage->full_address}}
			</p>
			<iframe src="https://maps.google.com/maps?q={{$garage->latitude}},{{$garage->longitude}}&hl=es&z=14&amp;output=embed" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>
@endcomponent