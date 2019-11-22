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
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47282.447413471076!2d-8.763538118216742!3d42.21117528718119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd1688eb921553af5!2sTalleres%20Garc%C3%ADa%20Barreiro%2C%20S.L.!5e0!3m2!1ses!2ses!4v1568141538557!5m2!1ses!2ses" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>
@endcomponent