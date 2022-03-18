@if($repair_order->appointment)
	@component('components.card')
		@slot('title', __('Cita'))

		@if(!$repair_order->appointment->vehicle_received)
			@slot('corner')
				<form method="POST" action="{{ route('garage.appointments.vehicle-received', $repair_order->appointment) }}">
					@csrf
					@method('PUT')
					<button class="btn-outline-gray">Recepcionar</button>
				</form>
			@endslot
		@endif

		@component('components.table')
			@slot('items', [
				'Fecha/Hora' => Carbon\Carbon::parse($repair_order->appointment->date_time)->format('d/m/Y H:i:s'),
				'Vehículo Recepcionado' => $repair_order->appointment->vehicle_received ? 'Si - ' . Carbon\Carbon::parse($repair_order->appointment->vehicle_received_at)->format('d/m/Y H:i:s') :'No',
				'Notas' => $repair_order->appointment->notes,
			])
		@endcomponent
	@endcomponent
@endif